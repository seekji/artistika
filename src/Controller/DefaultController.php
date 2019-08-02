<?php

namespace App\Controller;

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
     * DefaultController constructor.
     * @param SlidesService $slidesService
     */
    public function __construct(SlidesService $slidesService)
    {
        $this->slidesService = $slidesService;
    }

    /**
     * @Route("/", name="app.homepage")
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request)
    {
        return $this->render('default/index.html.twig', [
            'slides' => $this->slidesService->getActiveEventSlides()
        ]);
    }
}
