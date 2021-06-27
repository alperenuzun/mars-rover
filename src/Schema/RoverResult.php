<?php

namespace App\Schema;

use App\Traits\JsonSerializableTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;
use Symfony\Component\Serializer\Annotation\Groups;

class RoverResult implements \JsonSerializable
{
    use JsonSerializableTrait;

    /**
     * @var ArrayCollection $rovers
     * @SWG\Property(
     *     property="rovers",
     *     type="array",
     *     @SWG\Items(ref=@Model(type="\App\Schema\Rover", groups={"exposed_data"}))
     * )
     * @Groups("exposed_data")
     */
    private $rovers;

    public function __construct(ArrayCollection $rovers)
    {
        $this->rovers = $rovers;
    }

    /**
     * @return ArrayCollection
     */
    public function getRovers(): ArrayCollection
    {
        return $this->rovers;
    }
}
