<?php

namespace App\Schema;

use App\Traits\JsonSerializableTrait;
use Swagger\Annotations as SWG;
use Symfony\Component\Serializer\Annotation\Groups;

class Direction implements \JsonSerializable
{
    use JsonSerializableTrait;

    public const NORTH = 'N';
    public const EAST  = 'E';
    public const WEST  = 'W';
    public const SOUTH = 'S';

    private const DIRECTIONS = [self::NORTH, self::EAST, self::SOUTH, self::WEST];

    public const X_AXIS = 'X';
    public const Y_AXIS = 'Y';

    private const TURN_LEFT = [
        self::NORTH => self::WEST,
        self::EAST  => self::NORTH,
        self::SOUTH => self::EAST,
        self::WEST  => self::SOUTH,
    ];

    private const TURN_RIGHT = [
        self::NORTH => self::EAST,
        self::EAST  => self::SOUTH,
        self::SOUTH => self::WEST,
        self::WEST  => self::NORTH,
    ];

    private const AXIS_MAP = [
        self::NORTH => self::Y_AXIS,
        self::EAST  => self::X_AXIS,
        self::SOUTH => self::Y_AXIS,
        self::WEST  => self::X_AXIS,
    ];

    private const AXIS_VALUE_MAP = [
        self::NORTH =>  1,
        self::EAST  =>  1,
        self::SOUTH => -1,
        self::WEST  => -1,
    ];

    /**
     * @var string $direction
     * @SWG\Property(
     *     property="direction",
     *     type="string",
     *     description="Rover heading",
     *     example="N"
     * )
     * @Groups("exposed_data")
     */
    private $direction;

    /**
     * @param string $direction
     */
    public function __construct(string $direction)
    {
        $this->direction = $direction;
    }

    /**
     * @param Spin $spin
     * @return Direction
     */
    public function changeDirection(Spin $spin): self
    {
        if (Spin::LEFT === (string)$spin) {
            return new self(self::TURN_LEFT[$this->direction]);
        }

        return new self(self::TURN_RIGHT[$this->direction]);
    }

    /**
     * @return string
     */
    public function axis(): string
    {
        return self::AXIS_MAP[$this->direction];
    }

    /**
     * @return int
     */
    public function axisValue(): int
    {
        return self::AXIS_VALUE_MAP[$this->direction];
    }

    /**
     * @return string
     */
    public function getDirection(): string
    {
        return $this->direction;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->direction;
    }
}
