<?php

namespace App\Repository;

use App\Entity\PriznaArea;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method PriznaArea|null find($id, $lockMode = null, $lockVersion = null)
 * @method PriznaArea|null findOneBy(array $criteria, array $orderBy = null)
 * @method PriznaArea[]    findAll()
 * @method PriznaArea[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PriznaAreaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PriznaArea::class);
    }

    // /**
    //  * @return PriznaArea[] Returns an array of PriznaArea objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?PriznaArea
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
