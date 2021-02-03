<?php

namespace App\Repository;

use App\Entity\Killer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Killer|null find($id, $lockMode = null, $lockVersion = null)
 * @method Killer|null findOneBy(array $criteria, array $orderBy = null)
 * @method Killer[]    findAll()
 * @method Killer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class KillerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Killer::class);
    }

    // /**
    //  * @return Killer[] Returns an array of Killer objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('k')
            ->andWhere('k.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('k.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Killer
    {
        return $this->createQueryBuilder('k')
            ->andWhere('k.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
