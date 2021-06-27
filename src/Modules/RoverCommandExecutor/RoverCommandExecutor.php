<?php

namespace App\Modules\RoverCommandExecutor;

use App\Modules\RoverCommandExecutor\Parameters\RoverParameters;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\ParameterBag;

class RoverCommandExecutor
{
    /** @var RoverCommandExecutorManager */
    private $roverCommandExecutorManager;

    public function __construct(RoverCommandExecutorManager $roverCommandExecutorManager)
    {
        $this->roverCommandExecutorManager = $roverCommandExecutorManager;
    }

    public function executeCommand(ParameterBag $parameters): ?ArrayCollection
    {
        $commands = $parameters->get('commands', '');
        $roverParameters = (new RoverParameters())->setRequestCommands($commands);

        $rovers = $this->roverCommandExecutorManager->execute($roverParameters);

        return $rovers->getRovers();
    }
}
