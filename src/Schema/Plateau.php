<?php

namespace App\Schema;

use App\Traits\JsonSerializableTrait;
use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;
use Symfony\Component\Serializer\Annotation\Groups;

class Plateau implements \JsonSerializable
{
    use JsonSerializableTrait;

    /**
     * @var int|null $id
     * @SWG\Property(
     *     property="id",
     *     type="integer",
     *     description="Plateau ID",
     *     example=1
     * )
     * @Groups("exposed_data")
     */
    private $id;

    /**
     * @var Position $position
     * @SWG\Property(property="position", ref=@Model(type="\App\Schema\Position", groups={"exposed_data"})))
     * @Groups("exposed_data")
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
     * @return Position
     */
    public function getPosition(): Position
    {
        return $this->position;
    }

    /**
     * @return string
     * @Groups("excluded_data")
     */
    public function __toString(): string
    {
        return (string)$this->position;
    }
}
