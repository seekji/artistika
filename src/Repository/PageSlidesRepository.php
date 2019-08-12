<?php

namespace App\Repository;

use App\Entity\PageSlides;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method PageSlides|null find($id, $lockMode = null, $lockVersion = null)
 * @method PageSlides|null findOneBy(array $criteria, array $orderBy = null)
 * @method PageSlides[]    findAll()
 * @method PageSlides[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PageSlidesRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, PageSlides::class);
    }

    // /**
    //  * @return PageSlides[] Returns an array of PageSlides objects
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
    public function findOneBySomeField($value): ?PageSlides
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
