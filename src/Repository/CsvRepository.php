<?php

namespace App\Repository;

use App\Entity\Csv;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Csv|null find($id, $lockMode = null, $lockVersion = null)
 * @method Csv|null findOneBy(array $criteria, array $orderBy = null)
 * @method Csv[]    findAll()
 * @method Csv[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CsvRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Csv::class);
    }

    // /**
    //  * @return Csv[] Returns an array of Csv objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Csv
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
