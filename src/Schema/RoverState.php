<?php

namespace App\Schema;

use App\Traits\JsonSerializableTrait;

class RoverState implements \JsonSerializable
{
    use JsonSerializableTrait;

    /** @var string */
    private $state;

    public function __construct(string $state)
    {
        $this->state = $state;
    }

    /**
     * @return string
     */
    public function getState(): string
    {
        return $this->state;
    }
}
