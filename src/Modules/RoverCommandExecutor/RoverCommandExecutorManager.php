<?php

namespace App\Modules\RoverCommandExecutor;

use App\Modules\RoverCommandExecutor\Handlers\CommandHandler;
use App\Modules\RoverCommandExecutor\Handlers\CommandValidatorHandler;
use App\Modules\RoverCommandExecutor\Parameters\RoverParameters;

class RoverCommandExecutorManager
{
    /** @var CommandValidatorHandler */
    private $commandValidatorHandler;

    /** @var CommandHandler */
    private $commandHandler;

    private $initHandler;

    public function __construct(CommandValidatorHandler $commandValidatorHandler, CommandHandler $commandHandler)
    {
        $this->commandValidatorHandler = $commandValidatorHandler;
        $this->commandHandler = $commandHandler;
    }

    public function execute(RoverParameters $roverParameters): RoverParameters
    {
        return $this->getInitHandler()->handle($roverParameters);
    }

    /**
     * @required
     */
    public function prepareHandlers()
    {
        $this->commandValidatorHandler->setNextHandler($this->commandHandler);

        $this->setInitHandler($this->commandValidatorHandler);
    }

    /**
     * @return mixed
     */
    public function getInitHandler()
    {
        return $this->initHandler;
    }

    /**
     * @param mixed $initHandler
     */
    public function setInitHandler($initHandler): void
    {
        $this->initHandler = $initHandler;
    }
}
