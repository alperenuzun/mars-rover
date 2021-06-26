<?php

namespace App\Schema;

class Position
{
    /** @var Point */
    private $positionX;

    /** @var Point */
    private $positionY;

    /**
     * @param Point $positionX
     * @param Point $positionY
     */
    public function __construct(Point $positionX, Point $positionY)
    {
        $this->positionX = $positionX;
        $this->positionY = $positionY;
    }

    /**
     * @param Point $x
     * @param Point $y
     * @return $this
     */
    public function changePosition(Point $x, Point $y): self
    {
        return new self($x, $y);
    }

    /**
     * @return Point
     */
    public function getPositionX(): Point
    {
        return $this->positionX;
    }

    /**
     * @return Point
     */
    public function getPositionY(): Point
    {
        return $this->positionY;
    }

    public function __toString(): string
    {
        return $this->positionX.' '.$this->positionY;
    }
}
