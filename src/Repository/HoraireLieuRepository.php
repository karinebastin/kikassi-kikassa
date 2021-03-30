<?php

namespace App\Repository;

use App\Entity\HoraireLieu;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method HoraireLieu|null find($id, $lockMode = null, $lockVersion = null)
 * @method HoraireLieu|null findOneBy(array $criteria, array $orderBy = null)
 * @method HoraireLieu[]    findAll()
 * @method HoraireLieu[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HoraireLieuRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, HoraireLieu::class);
    }

    // /**
    //  * @return HoraireLieu[] Returns an array of HoraireLieu objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('h')
            ->andWhere('h.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('h.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?HoraireLieu
    {
        return $this->createQueryBuilder('h')
            ->andWhere('h.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
