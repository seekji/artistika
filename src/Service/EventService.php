<?php

namespace App\Service;

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
     * @param int $offset
     * @param int $limit
     * @param array $tags
     * @param int|null $city
     *
     * @return null|array
     */
    public function getEventsByFilter(int $offset = 0, int $limit = 20, array $tags = [], int $city = null): ?array
    {
        return $this->eventRepository->getEventsByFilter($offset, $limit, $tags, $city);
    }

    /**
     * @param array $tags
     * @param int|null $city
     * @return int
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getEventsCountByFilter(array $tags = [], int $city = null): int
    {
        return $this->eventRepository->getEventsCountByFilter($tags, $city);
    }
}