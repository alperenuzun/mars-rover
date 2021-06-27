<?php

namespace App\Service;

use App\Builder\PlateauBuilder;
use App\Repository\Interfaces\PlateauRepositoryInterface;
use App\Schema\Plateau;
use App\Service\Interfaces\PlateauServiceInterface;

class PlateauService implements PlateauServiceInterface
{
    /** @var PlateauRepositoryInterface */
    private $plateauRepository;

    public function __construct(PlateauRepositoryInterface $plateauRepository)
    {
        $this->plateauRepository = $plateauRepository;
    }

    public function getPlateau(int $id): ?Plateau
    {
        $plateau = $this->plateauRepository->getPlateau($id);

        return $plateau ? PlateauBuilder::createSchemaFromEntity($plateau) : null;
    }

    public function createPlateau(int $width, int $height): Plateau
    {
        $plateauEntity = PlateauBuilder::createEntity($width, $height);
        $this->plateauRepository->save($plateauEntity);

        return PlateauBuilder::createSchemaFromEntity($plateauEntity);
    }
}
