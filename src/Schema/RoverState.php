<?php

namespace App\Schema;

use App\Traits\JsonSerializableTrait;
use Swagger\Annotations as SWG;
use Symfony\Component\Serializer\Annotation\Groups;

class RoverState implements \JsonSerializable
{
    use JsonSerializableTrait;

    /**
     * @var string
     * @SWG\Property(
     *     property="state",
     *     type="string",
     *     description="Deployment coordinate of the rover and the heading",
     *     example="1 2 N"
     * )
     * @Groups("exposed_data")
     */
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
