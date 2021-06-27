<?php

namespace App\Schema;

use App\Traits\JsonSerializableTrait;
use Swagger\Annotations as SWG;
use Symfony\Component\Serializer\Annotation\Groups;

class Point implements \JsonSerializable
{
    use JsonSerializableTrait;

    /**
     * @var int $point
     * @SWG\Property(
     *     property="point",
     *     type="integer",
     *     description="A point in the coordinate system",
     *     example=1
     * )
     * @Groups("exposed_data")
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
     * @return int
     */
    public function getPoint(): int
    {
        return $this->point;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return (string)$this->point;
    }
}
