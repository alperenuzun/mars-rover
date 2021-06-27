<?php

namespace App\Service;

use App\Builder\RoverBuilder;
use App\Repository\Interfaces\PlateauRepositoryInterface;
use App\Repository\Interfaces\RoverRepositoryInterface;
use App\Schema\Rover;
use App\Service\Interfaces\RoverServiceInterface;

class RoverService implements RoverServiceInterface
{
    /** @var RoverRepositoryInterface */
    private $roverRepository;

    /** @var PlateauRepositoryInterface */
    private $plateauRepository;

    public function __construct(
        RoverRepositoryInterface $roverRepository,
        PlateauRepositoryInterface $plateauRepository
    ) {
        $this->roverRepository = $roverRepository;
        $this->plateauRepository = $plateauRepository;
    }

    public function getRover(int $roverId): ?Rover
    {
        $rover = $this->roverRepository->getRover($roverId);

        return $rover ? RoverBuilder::createSchemaFromEntity($rover) : null;
    }

    public function createRover(int $plateauId, int $positionX, int $positionY, string $direction): Rover
    {
        $plateau = $this->plateauRepository->getPlateau($plateauId);
        $roverEntity = RoverBuilder::createEntity($plateau, $positionX, $positionY, $direction);
        $this->roverRepository->save($roverEntity);

        return RoverBuilder::createSchemaFromEntity($roverEntity);
    }
}
