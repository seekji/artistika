<?php

namespace App\Service;

use App\Entity\Handbook\City;
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


    public function getActiveEventSlidesByCity(City $city): array
    {
        return $this->eventSliderRepository->getActiveEventSlidesByCity($city);
    }
}