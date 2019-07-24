<?php

namespace App\Controller;

use App\Entity\Handbook\City;
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
     * @Route("-{slug}", name="app.city")
     */
    public function indexAction(Request $request, City $city)
    {
        return $this->render('city/index.html.twig', ['city' => $city]);
    }
}
