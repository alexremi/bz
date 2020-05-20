<?php

namespace App\Repository;

use App\Entity\KlPr;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method KlPr|null find($id, $lockMode = null, $lockVersion = null)
 * @method KlPr|null findOneBy(array $criteria, array $orderBy = null)
 * @method KlPr[]    findAll()
 * @method KlPr[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class KlPrRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, KlPr::class);
    }

    // /**
    //  * @return KlPr[] Returns an array of KlPr objects
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
    public function findOneBySomeField($value): ?KlPr
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
