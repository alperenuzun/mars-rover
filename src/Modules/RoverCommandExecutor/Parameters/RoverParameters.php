<?php

namespace App\Modules\RoverCommandExecutor\Parameters;

use Doctrine\Common\Collections\ArrayCollection;
use Throwable;

class RoverParameters
{
    /** @var mixed|null */
    private $requestCommands;

    /** @var array */
    private $commands;

    /** @var ArrayCollection|null */
    private $rovers = null;

    /** @var Throwable|null */
    private $lastException = null;

    /**
     * @return mixed|null
     */
    public function getRequestCommands()
    {
        return $this->requestCommands;
    }

    /**
     * @param mixed|null $requestCommands
     */
    public function setRequestCommands($requestCommands): self
    {
        $this->requestCommands = $requestCommands;

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getRovers(): ?ArrayCollection
    {
        return $this->rovers;
    }

    /**
     * @param ArrayCollection $rovers
     * @return RoverParameters
     */
    public function setRovers(ArrayCollection $rovers): self
    {
        $this->rovers = $rovers;

        return $this;
    }

    /**
     * @return Throwable|null
     */
    public function getLastException(): ?Throwable
    {
        return $this->lastException;
    }

    /**
     * @param Throwable|null $lastException
     */
    public function setLastException(?Throwable $lastException): void
    {
        $this->lastException = $lastException;
    }

    /**
     * @return array
     */
    public function getCommands(): array
    {
        return $this->commands;
    }

    /**
     * @param array $commands
     * @return RoverParameters
     */
    public function setCommands(array $commands): self
    {
        $this->commands = $commands;

        return $this;
    }
}
