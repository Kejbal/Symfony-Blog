<?php

namespace App\Repository;

use App\Entity\GroupConfig;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method GroupConfig|null find($id, $lockMode = null, $lockVersion = null)
 * @method GroupConfig|null findOneBy(array $criteria, array $orderBy = null)
 * @method GroupConfig[]    findAll()
 * @method GroupConfig[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GroupConfigRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, GroupConfig::class);
    }

    // /**
    //  * @return GroupConfig[] Returns an array of GroupConfig objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('g.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?GroupConfig
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
