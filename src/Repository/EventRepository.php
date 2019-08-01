<?php

namespace App\Repository;

use App\Entity\Event;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Event|null find($id, $lockMode = null, $lockVersion = null)
 * @method Event|null findOneBy(array $criteria, array $orderBy = null)
 * @method Event[]    findAll()
 * @method Event[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EventRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Event::class);
    }

    /**
     * @param int $offset
     * @param int $limit
     * @param array $tags
     * @param int|null $city
     * @return array|null
     */
    public function getEventsByFilter(int $offset = 0, int $limit = 20, $tags = [], int $city = null): ?array
    {
        $query = $this
            ->createQueryBuilder('event')
            ->leftJoin('event.tags', 'tag');

        if(is_array($tags) && !empty($tags)) {
            $query->andWhere('tag.id IN (:tags)')
                ->setParameter('tags', $tags);
        }

        if($city !== null) {
            $query->andWhere('event.city = :city')
                ->setParameter('city', $city);
        }

        return $query
            ->addOrderBy('event.startedAt', 'ASC')
            ->setFirstResult($offset)
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }

    /**
     * @param array $tags
     * @param string|null $city
     * @return int
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getEventsCountByFilter($tags = [], string $city = null): int
    {
        $query = $this
            ->createQueryBuilder('event')
            ->select('COUNT(event.id)')
            ->leftJoin('event.tags', 'tag');

        if(is_array($tags) && !empty($tags)) {
            $query->andWhere('tag.id IN (:tags)')
                ->setParameter('tags', $tags);
        }

        if($city !== null) {
            $query->andWhere('event.city = :city')
                ->setParameter('city', $city);
        }

        return $query
            ->addOrderBy('event.startedAt', 'ASC')
            ->getQuery()
            ->getSingleScalarResult();
    }

    // /**
    //  * @return Event[] Returns an array of Event objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Event
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
