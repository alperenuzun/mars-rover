<?php

namespace App\Entity;

use App\Repository\RoverRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RoverRepository::class)
 */
class Rover
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id = 0;

    /**
     * @ORM\Column(type="integer")
     */
    private $positionX;

    /**
     * @ORM\Column(type="integer")
     */
    private $positionY;

    /**
     * @ORM\Column(type="string", length=1)
     */
    private $direction;

    /**
     * @ORM\ManyToOne(targetEntity=Plateau::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $plateau;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPositionX(): ?int
    {
        return $this->positionX;
    }

    public function setPositionX(int $positionX): self
    {
        $this->positionX = $positionX;

        return $this;
    }

    public function getPositionY(): ?int
    {
        return $this->positionY;
    }

    public function setPositionY(int $positionY): self
    {
        $this->positionY = $positionY;

        return $this;
    }

    public function getDirection(): ?string
    {
        return $this->direction;
    }

    public function setDirection(string $direction): self
    {
        $this->direction = $direction;

        return $this;
    }

    public function getPlateau(): ?Plateau
    {
        return $this->plateau;
    }

    public function setPlateau(?Plateau $plateau): self
    {
        $this->plateau = $plateau;

        return $this;
    }
}
