<?php

namespace App\Builder;

use App\Entity\Plateau;
use App\Entity\Rover;
use App\Schema\Direction;
use App\Schema\Point;
use App\Schema\Position;
use App\Schema\Rover as RoverSchema;

class RoverBuilder
{
    public static function createSchemaFromEntity(Rover $rover): RoverSchema
    {
        $plateauSchema = new RoverSchema(
            new Direction($rover->getDirection()),
            new Position(
                new Point($rover->getPositionX()),
                new Point($rover->getPositionY())
            )
        );
        $plateauSchema->setId($rover->getId());

        return $plateauSchema;
    }

    public static function createEntity(Plateau $plateau, int $positionX, int $positionY, string $direction): Rover
    {
        $rover = new Rover();
        $rover->setPositionX($positionX);
        $rover->setPositionY($positionY);
        $rover->setDirection($direction);
        $rover->setPlateau($plateau);

        return $rover;
    }
}
