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
    /**
     * @var \DateTime $currentDate
     */
    private $currentDate;

    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Event::class);

        $this->currentDate = new \DateTime('now');
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
            ->andWhere('event.startedAt >= :currentDate')
            ->setParameter('city', $city)
            ->setParameter('currentDate', $this->currentDate->format('Y-m-d'))
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
            ->andWhere('event.startedAt >= :currentDate')
            ->leftJoin('event.tags', 'tags')
            ->select('tags.title', 'tags.id')
            ->setParameter('city', $city)
            ->setParameter('currentDate', $this->currentDate->format('Y-m-d'))
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
     * @param bool $isArchive
     * @return array|null
     */
    public function getEventsByFilter(int $offset = 0, int $limit = 20, $tags = [], int $city = null, bool $isArchive = false): ?array
    {
        $query = $this
            ->createQueryBuilder('event')
            ->where('event.isActive = true')
            ->leftJoin('event.tags', 'tags');

        if($isArchive === true) {
            $query
                ->andWhere('event.startedAt < :date')
                ->setParameter(':date', $this->currentDate->format('Y-m-d'))
                ->orderBy('event.startedAt', 'DESC')
            ;
        } else {
            $query
                ->andWhere('event.startedAt >= :date')
                ->setParameter(':date', $this->currentDate->format('Y-m-d'))
                ->orderBy('event.startedAt', 'ASC')
            ;
        }

        if($city !== null) {
            $query->andWhere('event.city = :city')
                ->setParameter('city', $city);
        }

        if(is_array($tags) && !empty($tags) && count($tags) > 0) {
            $query->andWhere('tags.id IN (:tags)')
                ->setParameter('tags', $tags);
        }

        return $query
            ->groupBy('event')
            ->setFirstResult($offset)
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }

    /**
     * @param array $tags
     * @param int|null $city
     * @param bool $isArchive
     * @return int
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getEventsCountByFilter($tags = [], int $city = null, bool $isArchive = false): int
    {
        $query = $this
            ->createQueryBuilder('event')
            ->select('COUNT(DISTINCT event.id)')
            ->where('event.isActive = true')
            ->leftJoin('event.tags', 'tags');

        if($isArchive === true) {
            $query
                ->andWhere('event.startedAt < :date')
                ->setParameter(':date', $this->currentDate->format('Y-m-d'));
        } else {
            $query
                ->andWhere('event.startedAt >= :date')
                ->setParameter(':date', $this->currentDate->format('Y-m-d'));
        }

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

    /**
     * @param string $query
     * @return array
     */
    public function searchEventsByQuery(string $query): array
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
            ->getArrayResult()
        ;
    }

    /**
     * @param City $city
     * @param int $offset
     * @param int $limit
     * @return array|null
     */
    public function getArchiveEventsByCity(City $city, int $offset = 0, int $limit = 20): ?array
    {
        return $this->createQueryBuilder('event')
            ->where('event.isActive = true')
            ->andWhere('event.city = :city')
            ->andWhere('event.startedAt < :currentDate')
            ->setParameter('city', $city)
            ->setParameter('currentDate', $this->currentDate->format('Y-m-d'))
            ->addOrderBy('event.startedAt', 'DESC')
            ->setFirstResult($offset)
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }

    public function getArchiveEventTagsByCity(City $city)
    {
        return $this->createQueryBuilder('event')
            ->andWhere('event.city = :city')
            ->andWhere('event.isActive = true')
            ->andWhere('event.startedAt < :currentDate')
            ->leftJoin('event.tags', 'tags')
            ->select('tags.title', 'tags.id')
            ->setParameter('city', $city)
            ->setParameter('currentDate', $this->currentDate->format('Y-m-d'))
            ->addOrderBy('tags.title', 'ASC')
            ->groupBy('tags.title')
            ->getQuery()
            ->getResult();
    }
}
