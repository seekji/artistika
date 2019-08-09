<?php

namespace App\Controller;

use App\Service\CityService;
use App\Service\EventService;
use App\Service\SlidesService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class DefaultController
 * @package App\Controller
 */
class DefaultController extends AbstractController
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
     * DefaultController constructor.
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
     * @Route("/", name="app.homepage")
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request)
    {
        $defaultCity = $this->cityService->getDefaultCity();

        return $this->render('default/index.html.twig', [
            'slides' => $this->slidesService->getActiveEventSlidesByCity($defaultCity),
            'events' => $this->eventService->getEventsByCity($defaultCity),
            'tags' => $this->eventService->getEventTagsByCity($defaultCity)
        ]);
    }
}
