<?php

namespace App\Schema;

class Rover
{
    /** @var Direction */
    private $direction;

    /** @var Position */
    private $position;

    /**
     * @param Direction $direction
     * @param Position $position
     */
    public function __construct(Direction $direction, Position $position)
    {
        $this->direction = $direction;
        $this->position  = $position;
    }

    public function spin(Spin $spin): void
    {
        $this->direction = $this->direction->changeDirection($spin);
    }

    public function move(Move $move): void
    {
        $value = $move->factor($this->direction->axisValue());

        if (Direction::X_AXIS === $this->direction->axis()) {

            $this->position = $this->position->changePosition(
                $this->position->getPositionX()->movePoint($value),
                $this->position->getPositionY()
            );

            return;
        }

        $this->position = $this->position->changePosition(
            $this->position->getPositionX(),
            $this->position->getPositionY()->movePoint($value)
        );
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->position . ' ' . $this->direction;
    }
}
