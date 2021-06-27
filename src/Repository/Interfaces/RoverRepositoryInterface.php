<?php

namespace App\Repository\Interfaces;

use App\Entity\Rover;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;

interface RoverRepositoryInterface
{
    public function getRover(int $id): ?Rover;

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */
    public function save(Rover $rover): void;

    public function getAllRovers(): array;

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */
    public function flushChanges(): void;
}
