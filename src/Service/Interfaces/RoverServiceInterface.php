<?php

namespace App\Service\Interfaces;

use App\Schema\Rover;

interface RoverServiceInterface
{
    public function getRover(int $roverId): ?Rover;

    public function createRover(int $plateauId, int $positionX, int $positionY, string $direction): Rover;
}
