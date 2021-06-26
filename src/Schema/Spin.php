<?php

namespace App\Schema;

class Spin
{
    public const LEFT  = 'L';
    public const RIGHT = 'R';
    public const SPINS = [self::LEFT, self::RIGHT];

    /** @var string */
    private $spin;

    /**
     * @param string $spin
     */
    public function __construct(string $spin)
    {
        $this->spin = $spin;
    }

    public function __toString(): string
    {
        return $this->spin;
    }
}
