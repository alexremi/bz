<?php

namespace App\Repository;

use App\Entity\ZnPr;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method ZnPr|null find($id, $lockMode = null, $lockVersion = null)
 * @method ZnPr|null findOneBy(array $criteria, array $orderBy = null)
 * @method ZnPr[]    findAll()
 * @method ZnPr[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ZnPrRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ZnPr::class);
    }

    // /**
    //  * @return ZnPr[] Returns an array of ZnPr objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('z')
            ->andWhere('z.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('z.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ZnPr
    {
        return $this->createQueryBuilder('z')
            ->andWhere('z.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
