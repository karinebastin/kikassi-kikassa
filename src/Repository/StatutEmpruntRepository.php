<?php

namespace App\Repository;

use App\Entity\StatutEmprunt;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method StatutEmprunt|null find($id, $lockMode = null, $lockVersion = null)
 * @method StatutEmprunt|null findOneBy(array $criteria, array $orderBy = null)
 * @method StatutEmprunt[]    findAll()
 * @method StatutEmprunt[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StatutEmpruntRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, StatutEmprunt::class);
    }

    // /**
    //  * @return StatutEmprunt[] Returns an array of StatutEmprunt objects
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
    public function findOneBySomeField($value): ?StatutEmprunt
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
