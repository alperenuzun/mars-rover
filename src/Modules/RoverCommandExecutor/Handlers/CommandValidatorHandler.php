<?php

namespace App\Modules\RoverCommandExecutor\Handlers;

use App\Modules\RoverCommandExecutor\AbstractHandler\AbstractChainHandler;
use App\Modules\RoverCommandExecutor\Parameters\RoverParameters;

class CommandValidatorHandler extends AbstractChainHandler
{
    public function process(RoverParameters $roverParameters): RoverParameters
    {
        $commands = $roverParameters->getRequestCommands();

        $commands = str_split($commands);

        $roverParameters->setCommands($commands);

        return $roverParameters;
    }
}
