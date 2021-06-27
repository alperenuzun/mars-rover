<?php

namespace App\Repository;

use App\Entity\Plateau;
use App\Repository\Interfaces\PlateauRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Plateau|null find($id, $lockMode = null, $lockVersion = null)
 * @method Plateau|null findOneBy(array $criteria, array $orderBy = null)
 * @method Plateau[]    findAll()
 * @method Plateau[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PlateauRepository extends ServiceEntityRepository implements PlateauRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Plateau::class);
    }

    public function getPlateau(int $plateauId): ?Plateau
    {
        return $this->findOneBy(['id' => $plateauId]);
    }

    public function save(Plateau $plateau): void
    {
        $this->_em->persist($plateau);
        $this->_em->flush();
    }
}
