<?php

namespace App\Service\Interfaces;

use App\Schema\Plateau;

interface PlateauServiceInterface
{
    public function getPlateau(int $id): ?Plateau;

    public function createPlateau(int $width, int $height): Plateau;
}
