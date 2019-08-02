<?php

namespace App\Controller;

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
     * @Route("/", name="app.archive.default")
     *
     * @return Response
     */
    public function defaultCity()
    {
        return $this->render('archive/default.html.twig');
    }

    /**
     * @Route("/{slug}/", name="app.archive.city")
     *
     * @return Response
     */
    public function city()
    {
        return $this->render('archive/city.html.twig');
    }
}
