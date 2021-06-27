<?php

namespace App\Modules\RoverCommandExecutor\Handlers;

use App\Builder\RoverBuilder;
use App\Entity\Rover;
use App\Modules\RoverCommandExecutor\AbstractHandler\AbstractChainHandler;
use App\Modules\RoverCommandExecutor\Parameters\RoverParameters;
use App\Service\Interfaces\RoverNavigatorServiceInterface;
use App\Service\Interfaces\RoverServiceInterface;
use Doctrine\Common\Collections\ArrayCollection;

class CommandHandler extends AbstractChainHandler
{
    /** @var RoverServiceInterface */
    private $roverService;

    /** @var RoverNavigatorServiceInterface */
    private $roverNavigatorService;

    public function __construct(
        RoverServiceInterface $roverService,
        RoverNavigatorServiceInterface $roverNavigatorService
    ) {
        $this->roverService = $roverService;
        $this->roverNavigatorService = $roverNavigatorService;
    }

    public function isProcessable(RoverParameters $roverParameters): bool
    {
        return !$roverParameters->getLastException();
    }

    public function process(RoverParameters $roverParameters): RoverParameters
    {
        $roversResult = [];

        $movement = $roverParameters->getCommands();
        $rovers = $this->roverService->getAllRovers();

        /** @var Rover $rover */
        foreach ($rovers as $rover) {
            $roverSchema = RoverBuilder::createSchemaFromEntity($rover);

            $roverSchema = $this->roverNavigatorService->executeCommand($movement, $roverSchema);

            if (!$this->roverNavigatorService->isOutOfTheBorder($roverSchema, $rover)) {
                $roversResult[] = $roverSchema;

                $roverData = explode(' ', (string)$roverSchema);
                $rover->setPositionX($roverData[0])->setPositionY($roverData[1])->setDirection($roverData[2]);
            }
        }

        $this->roverService->flushRovers();

        $roverParameters->setRovers(new ArrayCollection($roversResult));

        return $roverParameters;
    }
}
