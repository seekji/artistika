<?php

    namespace App\Controller;

    use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
    use Symfony\Component\HttpFoundation\Request;
    use Symfony\Component\Routing\Annotation\Route;
    use Symfony\Component\HttpFoundation\Response;

    /**
     * Class PageController
     * @package App\Controller
     * @Route("/page")
     */
    class PageController extends AbstractController
    {
        /**
         * @Route("-{slug}/", name="app.page.show")
         *
         * @return Response
         */
        public function show()
        {
            return $this->render('page/index.html.twig');
        }
    }
