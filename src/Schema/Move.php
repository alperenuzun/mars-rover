<?php

namespace App\Schema;

class Move
{
    public const MOVEMENT = 'M';
    public const MOVEMENT_FACTOR = 1;

    public function factor(int $value)
    {
        return $value * self::MOVEMENT_FACTOR;
    }
}
