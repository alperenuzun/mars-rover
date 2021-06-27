<?php

namespace App\Schema;

use App\Traits\JsonSerializableTrait;

class Plateau implements \JsonSerializable
{
    use JsonSerializableTrait;

    /** @var int|null $id */
    private $id;

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
     * @return int
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return (string)$this->position;
    }
}
