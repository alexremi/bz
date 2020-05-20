<?php

namespace App\Repository;

use App\Entity\Prizn;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Prizn|null find($id, $lockMode = null, $lockVersion = null)
 * @method Prizn|null findOneBy(array $criteria, array $orderBy = null)
 * @method Prizn[]    findAll()
 * @method Prizn[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PriznRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Prizn::class);
    }

    // /**
    //  * @return Prizn[] Returns an array of Prizn objects
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
    public function findOneBySomeField($value): ?Prizn
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
