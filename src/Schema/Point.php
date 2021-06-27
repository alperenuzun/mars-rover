<?php

namespace App\Schema;

use App\Traits\JsonSerializableTrait;

class Point implements \JsonSerializable
{
    use JsonSerializableTrait;

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
