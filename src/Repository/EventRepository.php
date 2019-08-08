<?php

namespace App\Repository;

use App\Entity\Event;
use App\Entity\Handbook\City;
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
     * @param City $city
     * @param int $offset
     * @param int $limit
     * @return array|null
     */
    public function getEventsByCity(City $city, int $offset = 0, int $limit = 20): ?array
    {
        return $this->createQueryBuilder('event')
            ->where('event.isActive = true')
            ->andWhere('event.city = :city')
            ->setParameter('city', $city)
            ->addOrderBy('event.startedAt', 'ASC')
            ->setFirstResult($offset)
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }

    /**
     * @param City $city
     * @return array|null
     */
    public function getEventTagsByCity(City $city): ?array
    {
        return $this->createQueryBuilder('event')
            ->andWhere('event.city = :city')
            ->andWhere('event.isActive = true')
            ->leftJoin('event.tags', 'tags')
            ->select('tags.title', 'tags.id')
            ->setParameter('city', $city)
            ->addOrderBy('tags.title', 'ASC')
            ->groupBy('tags.title')
            ->getQuery()
            ->getResult();
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
            ->where('event.isActive = true')
            ->leftJoin('event.tags', 'tags');

        if($city !== null) {
            $query->andWhere('event.city = :city')
                ->setParameter('city', $city);
        }

        if(is_array($tags) && !empty($tags) && count($tags) > 0) {
            $query->andWhere('tags.id IN (:tags)')
                ->setParameter('tags', $tags);
        }

        return $query
            ->addOrderBy('event.startedAt', 'ASC')
            ->groupBy('event')
            ->setFirstResult($offset)
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }

    /**
     * @param array $tags
     * @param int|null $city
     * @return int
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getEventsCountByFilter($tags = [], int $city = null): int
    {
        $query = $this
            ->createQueryBuilder('event')
            ->select('COUNT(DISTINCT event.id)')
            ->where('event.isActive = true')
            ->leftJoin('event.tags', 'tags');

        if($city !== null) {
            $query->andWhere('event.city = :city')
                ->setParameter('city', $city);
        }

        if(is_array($tags) && !empty($tags) && count($tags) > 0) {
            $query->andWhere('tags.id IN (:tags)')
                ->setParameter('tags', $tags);
        }

        return $query
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function searchEventsByQuery(string $query)
    {
        $strings = explode(' ', $query);

        foreach($strings as $key => $string) {
            $strings[$key] = "{$string}*";
        }

        $query = implode(' ', $strings);

        return $this->createQueryBuilder('e')
            ->select('e.id', 'e.artist', 'e.startedAt', 'e.description', 'e.slug', 'city.name as cityName', 'city.slug as citySlug')
            ->where('MATCH (e.description, e.artist) AGAINST (:query boolean) > 0')
            ->leftJoin('e.city', 'city')
            ->setParameter('query', $query)
            ->orderBy('e.startedAt', 'ASC')
            ->setMaxResults(15)
            ->getQuery()
            ->getArrayResult();
        ;
    }
}
