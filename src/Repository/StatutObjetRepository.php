<?php

namespace App\Repository;

use App\Entity\StatutObjet;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method StatutObjet|null find($id, $lockMode = null, $lockVersion = null)
 * @method StatutObjet|null findOneBy(array $criteria, array $orderBy = null)
 * @method StatutObjet[]    findAll()
 * @method StatutObjet[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StatutObjetRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, StatutObjet::class);
    }

    // /**
    //  * @return StatutObjet[] Returns an array of StatutObjet objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?StatutObjet
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
