<?php

namespace App\Schema;

class Point
{
    /**
     * @var int $point
     */
    private $point;

    /**
     * @param int $point
     */
    public function __construct(int $point)
    {
        $this->point = $point;
    }

    /**
     * @param int $point
     * @return Point
     */
    public function movePoint(int $point): self
    {
        return new self($this->point + $point);
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return (string)$this->point;
    }
}
