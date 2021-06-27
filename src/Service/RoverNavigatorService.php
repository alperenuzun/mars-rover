<?php

namespace App\Service;

use App\Entity\Rover as RoverEntity;
use App\Schema\Move;
use App\Schema\Rover;
use App\Schema\Spin;
use App\Service\Interfaces\RoverNavigatorServiceInterface;

class RoverNavigatorService implements RoverNavigatorServiceInterface
{
    public function executeCommand(array $movement, Rover $rover): Rover
    {
        foreach ($movement as $operation) {
            if (in_array($operation, Spin::SPINS)) {
                $rover->spin(new Spin($operation));
            } elseif (in_array($operation, [Move::MOVEMENT])) {
                $rover->move(new Move());
            } else {
                throw new \InvalidArgumentException('Invalid command!');
            }
        }

        return $rover;
    }

    public function isOutOfTheBorder(Rover $rover, RoverEntity $roverEntity): bool
    {
        $roverState = (string)$rover;
        $roverData = explode(' ', $roverState);
        $roverPositionX = $roverData[0];
        $roverPositionY = $roverData[1];

        if ($roverEntity->getPlateau()->getHeight() < $roverPositionY ||
            $roverEntity->getPlateau()->getWidth() < $roverPositionX ||
            $roverPositionY < 0 || $roverPositionX < 0
        ) {
            return true;
        }

        return false;
    }
}
