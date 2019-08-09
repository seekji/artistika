<?php

namespace App\Service;

use App\Entity\Handbook\City;
use App\Repository\EventRepository;

/**
 * Class EventService
 * @package App\Service
 */
class EventService
{
    /**
     * @var EventRepository $eventRepository
     */
    protected $eventRepository;

    /**
     * NewsService constructor.
     * @param EventRepository $eventRepository
     */
    public function __construct(EventRepository $eventRepository)
    {
        $this->eventRepository = $eventRepository;
    }

    /**
     * @param City $city
     * @return \App\Entity\Event[]
     */
    public function getEventsByCity(City $city): array
    {
        return $this->eventRepository->getEventsByCity($city);
    }

    /**
     * @param int $offset
     * @param int $limit
     * @param array $tags
     * @param int|null $city
     *
     * @param bool $isArchive
     * @return null|\App\Entity\Event[]
     */
    public function getEventsByFilter(int $offset = 0, int $limit = 20, array $tags = [], int $city = null, bool $isArchive = false): ?array
    {
        return $this->eventRepository->getEventsByFilter($offset, $limit, $tags, $city, $isArchive);
    }

    /**
     * @param array $tags
     * @param int|null $city
     * @param bool $isArchive
     * @return int
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getEventsCountByFilter(array $tags = [], int $city = null, bool $isArchive = false): int
    {
        return $this->eventRepository->getEventsCountByFilter($tags, $city, $isArchive);
    }

    /**
     * @param City $city
     * @return mixed
     */
    public function getEventTagsByCity(City $city)
    {
        return $this->eventRepository->getEventTagsByCity($city);
    }

    /**
     * @param string $query
     * @return array
     */
    public function searchEvents(string $query)
    {
        return $this->eventRepository->searchEventsByQuery($query);
    }

    /**
     * @param City $city
     * @return array|null
     */
    public function getArchiveEventsByCity(City $city): ?array
    {
        return $this->eventRepository->getArchiveEventsByCity($city);
    }

    /**
     * @param City $city
     * @return array|null
     */
    public function getArchiveEventTagsByCity(City $city): ?array
    {
        return $this->eventRepository->getArchiveEventTagsByCity($city);
    }
}