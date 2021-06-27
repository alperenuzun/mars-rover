<?php

namespace App\Builder;

use App\Entity\Plateau;
use App\Schema\Plateau as PlateauSchema;
use App\Schema\Point;
use App\Schema\Position;

class PlateauBuilder
{
    public static function createSchemaFromEntity(Plateau $plateau): PlateauSchema
    {
        $plateauSchema = new PlateauSchema(
            new Position(
                new Point($plateau->getWidth()),
                new Point($plateau->getHeight())
            )
        );
        $plateauSchema->setId($plateau->getId());

        return $plateauSchema;
    }

    public static function createEntity(int $width, int $height): Plateau
    {
        $plateau = new Plateau();
        $plateau->setWidth($width);
        $plateau->setHeight($height);

        return $plateau;
    }
}
