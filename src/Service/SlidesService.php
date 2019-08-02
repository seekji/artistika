<?php

namespace App\Service;

use App\Repository\EventSliderRepository;

/**
 * Class SlidesService
 * @package App\Service
 */
class SlidesService
{
    /**
     * @var EventSliderRepository
     */
    protected $eventSliderRepository;

    /**
     * SlidesService constructor.
     * @param EventSliderRepository $eventSliderRepository
     */
    public function __construct(EventSliderRepository $eventSliderRepository)
    {
        $this->eventSliderRepository = $eventSliderRepository;
    }

    /**
     * @return array
     */
    public function getActiveEventSlides(): array
    {
        return $this->eventSliderRepository->findBy(['isActive' => true], ['sort' => 'ASC']);
    }
}