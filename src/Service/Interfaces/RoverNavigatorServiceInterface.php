<?php

namespace App\Service\Interfaces;

use App\Entity\Rover as RoverEntity;
use App\Schema\Rover;

interface RoverNavigatorServiceInterface
{
    /**
     * @param array $movement
     * @param Rover $rover
     * @return Rover
     */
    public function executeCommand(array $movement, Rover $rover): Rover;

    public function isOutOfTheBorder(Rover $rover, RoverEntity $roverEntity): bool;
}
