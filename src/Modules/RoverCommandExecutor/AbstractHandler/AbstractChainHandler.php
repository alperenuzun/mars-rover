<?php

namespace App\Modules\RoverCommandExecutor\AbstractHandler;

use App\Modules\RoverCommandExecutor\Parameters\RoverParameters;
use Throwable;

abstract class AbstractChainHandler
{
    /** @var AbstractChainHandler|null */
    private $nextHandler = null;

    abstract public function process(RoverParameters $roverParameters): RoverParameters;

    public function isProcessable(RoverParameters $roverParameters): bool
    {
        return true;
    }

    public function handle(RoverParameters $roverParameters): RoverParameters
    {
        try {
            if ($this->isProcessable($roverParameters)) {
                $roverParameters = $this->process($roverParameters);
            }

            if ($this->getNextHandler()) {
                $roverParameters = $this->getNextHandler()->handle($roverParameters);
            }

            return $roverParameters;
        } catch (Throwable $exception) {
            $roverParameters->setLastException($exception);

            throw $exception;
        }
    }

    public function getNextHandler(): ?AbstractChainHandler
    {
        return $this->nextHandler;
    }

    public function setNextHandler(?AbstractChainHandler $nextHandler): AbstractChainHandler
    {
        $this->nextHandler = $nextHandler;

        return $this;
    }
}
