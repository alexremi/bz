<?php

namespace App\Repository;

use App\Entity\Artefacts;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Artefacts|null find($id, $lockMode = null, $lockVersion = null)
 * @method Artefacts|null findOneBy(array $criteria, array $orderBy = null)
 * @method Artefacts[]    findAll()
 * @method Artefacts[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArtefactsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Artefacts::class);
    }

    // /**
    //  * @return Artefacts[] Returns an array of Artefacts objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Artefacts
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
