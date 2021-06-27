<?php

namespace App\Repository\Interfaces;

use App\Entity\Plateau;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;

interface PlateauRepositoryInterface
{
    public function getPlateau(int $plateauId): ?Plateau;

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */
    public function save(Plateau $plateau): void;
}
