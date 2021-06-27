<?php

namespace App\Schema;

use App\Traits\JsonSerializableTrait;
use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;
use Symfony\Component\Serializer\Annotation\Groups;

class Rover implements \JsonSerializable
{
    use JsonSerializableTrait;

    /**
     * @var int|null $id
     * @SWG\Property(
     *     property="id",
     *     type="integer",
     *     description="Rover ID",
     *     example=1
     * )
     * @Groups("exposed_data")
     */
    private $id;

    /**
     * @var Direction $direction
     * @SWG\Property(property="direction", ref=@Model(type="\App\Schema\Direction", groups={"exposed_data"})))
     * @Groups("exposed_data")
     */
    private $direction;

    /**
     * @var Position $position
     * @SWG\Property(property="position", ref=@Model(type="\App\Schema\Position", groups={"exposed_data"})))
     * @Groups("exposed_data")
     */
    private $position;

    /**
     * @param Direction $direction
     * @param Position $position
     */
    public function __construct(Direction $direction, Position $position)
    {
        $this->direction = $direction;
        $this->position  = $position;
    }

    public function spin(Spin $spin): void
    {
        $this->direction = $this->direction->changeDirection($spin);
    }

    public function move(Move $move): void
    {
        $value = $move->factor($this->direction->axisValue());

        if (Direction::X_AXIS === $this->direction->axis()) {

            $this->position = $this->position->changePosition(
                $this->position->getPositionX()->movePoint($value),
                $this->position->getPositionY()
            );

            return;
        }

        $this->position = $this->position->changePosition(
            $this->position->getPositionX(),
            $this->position->getPositionY()->movePoint($value)
        );
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
     * @return Direction
     */
    public function getDirection(): Direction
    {
        return $this->direction;
    }

    /**
     * @return Position
     */
    public function getPosition(): Position
    {
        return $this->position;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->position.' '.$this->direction;
    }
}
