<?php

namespace App\Controller;

use App\Entity\Handbook\City;
use App\Service\CityService;
use App\Service\EventService;
use App\Service\SlidesService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class CityController
 * @package App\Controller
 * @Route("/city")
 */
class CityController extends AbstractController
{
    /**
     * @var SlidesService
     */
    protected $slidesService;

    /**
     * @var EventService
     */
    protected $eventService;

    /**
     * @var CityService
     */
    protected $cityService;

    /**
     * CityController constructor.
     * @param SlidesService $slidesService
     * @param EventService $eventService
     * @param CityService $cityService
     */
    public function __construct(SlidesService $slidesService, EventService $eventService, CityService $cityService)
    {
        $this->slidesService = $slidesService;
        $this->eventService = $eventService;
        $this->cityService = $cityService;
    }

    /**
     * @Route("-{slug}/", name="app.city")
     *
     * @param Request $request
     * @param City $city
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request, City $city)
    {
        if($city->getIsDefault()) {
            return $this->redirectToRoute('app.homepage');
        }

        return $this->render('city/index.html.twig', [
            'currentCity' => $city,
            'events' => $this->eventService->getEventsByCity($city),
            'tags' => $this->eventService->getEventTagsByCity($city),
            'slides' => $this->slidesService->getActiveEventSlidesByCity($city)
        ]);
    }
}
