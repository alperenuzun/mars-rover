<?php

namespace App\Schema;

use App\Traits\JsonSerializableTrait;
use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;
use Symfony\Component\Serializer\Annotation\Groups;

class Position implements \JsonSerializable
{
    use JsonSerializableTrait;

    /**
     * @var Point $positionX
     * @SWG\Property(property="position_x", ref=@Model(type="\App\Schema\Point", groups={"exposed_data"})))
     * @Groups("exposed_data")
     */
    private $positionX;

    /**
     * @var Point $positionY
     * @SWG\Property(property="position_y", ref=@Model(type="\App\Schema\Point", groups={"exposed_data"})))
     * @Groups("exposed_data")
     */
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

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->positionX.' '.$this->positionY;
    }
}
