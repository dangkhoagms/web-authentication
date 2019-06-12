<?php

namespace App\Repository;

use App\Entity\TwitterUsername;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method TwitterUsername|null find($id, $lockMode = null, $lockVersion = null)
 * @method TwitterUsername|null findOneBy(array $criteria, array $orderBy = null)
 * @method TwitterUsername[]    findAll()
 * @method TwitterUsername[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TwitterUsernameRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, TwitterUsername::class);
    }

    // /**
    //  * @return TwitterUsername[] Returns an array of TwitterUsername objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?TwitterUsername
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
