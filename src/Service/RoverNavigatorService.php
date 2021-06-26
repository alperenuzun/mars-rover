<?php

namespace App\Service;

use App\Schema\Move;
use App\Schema\Rover;
use App\Schema\Spin;

class RoverNavigatorService
{
    private $rover;

    public function __construct(Rover $rover)
    {
        $this->rover = $rover;
    }

    /**
     * @param array $movement
     * @return string
     */
    public function executeCommand(array $movement): string
    {
        foreach ($movement as $operation) {
            if (in_array($operation, Spin::SPINS)) {
                $this->rover->spin(new Spin($operation));
            } elseif (in_array($operation, [Move::MOVEMENT])) {
                $this->rover->move(new Move());
            } else {
                throw new \InvalidArgumentException('Invalid command!');
            }
        }

        return (string)$this->rover;
    }
}
