<?php

namespace App\Modules\RoverCommandExecutor\Handlers;

use App\Modules\RoverCommandExecutor\AbstractHandler\AbstractChainHandler;
use App\Modules\RoverCommandExecutor\Parameters\RoverParameters;
use App\Schema\Move;
use App\Schema\Spin;

class CommandValidatorHandler extends AbstractChainHandler
{
    public function process(RoverParameters $roverParameters): RoverParameters
    {
        $commands = $roverParameters->getRequestCommands();
        $validCommands = array_merge(Spin::SPINS, [Move::MOVEMENT]);

        $commands = str_split($commands);

        foreach ($commands as $command) {
            if (!in_array($command, $validCommands)) {
                throw new \InvalidArgumentException('Please give a valid command!');
            }
        }

        $roverParameters->setCommands($commands);

        return $roverParameters;
    }
}
