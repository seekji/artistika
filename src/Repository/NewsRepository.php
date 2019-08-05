<?php

namespace App\Repository;

use App\Entity\News;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method News|null find($id, $lockMode = null, $lockVersion = null)
 * @method News|null findOneBy(array $criteria, array $orderBy = null)
 * @method News[]    findAll()
 * @method News[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NewsRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, News::class);
    }

    /**
     * @param int $offset
     * @param int $limit
     *
     * @return array|null
     */
    public function getListOfNews(int $offset = 0, int $limit = 50): ?array
    {
        return $this->createQueryBuilder('n')
            ->where('n.isPublished = true')
            ->addOrderBy('n.createdAt', 'DESC')
            ->addOrderBy('n.id', 'DESC')
            ->setFirstResult($offset)
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }

    /**
     * @param int $limit
     * @param array $exclude
     *
     * @return array|null
     */
    public function getLastNewsAndExclude(int $limit = 5, array $exclude = []): ?array
    {
       $query = $this->createQueryBuilder('n')
           ->where('n.isPublished = true')
           ->addOrderBy('n.createdAt', 'DESC')
           ->addOrderBy('n.id', 'DESC');

       if(count($exclude) > 0) {
           $query->andWhere('n.id NOT IN (:ids)')
               ->setParameter('ids', $exclude);
       }

       return $query
           ->setMaxResults($limit)
           ->getQuery()
           ->getResult();

    }

    // /**
    //  * @return News[] Returns an array of News objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('n.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?News
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
