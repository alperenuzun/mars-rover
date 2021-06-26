<?php

namespace App\Schema;

class Plateau
{
    /**
     * @var Position|null $position
     */
    private $position;

    /**
     * @param Position $position
     */
    public function __construct(Position $position)
    {
        $this->position = $position;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return (string)$this->position;
    }
}
