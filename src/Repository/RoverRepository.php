<?php

namespace App\Repository;

use App\Entity\Rover;
use App\Repository\Interfaces\RoverRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Rover|null find($id, $lockMode = null, $lockVersion = null)
 * @method Rover|null findOneBy(array $criteria, array $orderBy = null)
 * @method Rover[]    findAll()
 * @method Rover[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RoverRepository extends ServiceEntityRepository implements RoverRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Rover::class);
    }

    public function getRover(int $id): ?Rover
    {
        return $this->findOneBy(['id' => $id]);
    }

    public function save(Rover $rover): void
    {
        $this->_em->persist($rover);
        $this->_em->flush();
    }

    public function getAllRovers(): array
    {
        return $this->findAll();
    }

    public function flushChanges(): void
    {
        $this->_em->flush();
    }
}
