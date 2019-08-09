<?php

namespace App\Controller;

use App\Entity\Handbook\City;
use App\Service\CityService;
use App\Service\EventService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class ArchiveController
 * @package App\Controller
 * @Route("/archive")
 */
class ArchiveController extends AbstractController
{
    /**
     * @var CityService $cityService
     */
    protected $cityService;

    /**
     * @var EventService $eventService
     */
    protected $eventService;

    /**
     * ArchiveController constructor.
     * @param CityService $cityService
     * @param EventService $eventService
     */
    public function __construct(CityService $cityService, EventService $eventService)
    {
        $this->cityService = $cityService;
        $this->eventService = $eventService;
    }

    /**
     * @Route("/", name="app.archive.default")
     *
     * @return Response
     */
    public function default()
    {
        $defaultCity = $this->cityService->getDefaultCity();

        return $this->render('archive/default.html.twig', [
            'events' => $this->eventService->getArchiveEventsByCity($defaultCity),
            'tags' => $this->eventService->getArchiveEventTagsByCity($defaultCity),
        ]);
    }

    /**
     * @Route("/{slug}/", name="app.archive.city")
     *
     * @param City $city
     *
     * @return Response
     */
    public function city(City $city)
    {
        return $this->render('archive/city.html.twig', [
            'currentCity' => $city,
            'events' => $this->eventService->getArchiveEventsByCity($city),
            'tags' => $this->eventService->getArchiveEventTagsByCity($city),
        ]);
    }
}
