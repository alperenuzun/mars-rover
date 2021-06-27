<?php

namespace App\Schema;

use App\Traits\JsonSerializableTrait;
use Doctrine\Common\Collections\ArrayCollection;

class RoverResult implements \JsonSerializable
{
    use JsonSerializableTrait;

    /** @var ArrayCollection */
    private $rovers;

    public function __construct(ArrayCollection $rovers)
    {
        $this->rovers = $rovers;
    }
}
