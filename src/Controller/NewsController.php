<?php

    namespace App\Controller;

    use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
    use Symfony\Component\HttpFoundation\Request;
    use Symfony\Component\Routing\Annotation\Route;
    use Symfony\Component\HttpFoundation\Response;

    /**
     * Class NewsController
     * @package App\Controller
     * @Route("/news")
     */
    class NewsController extends AbstractController
    {
        /**
         * @Route("/", name="app.news.list")
         *
         * @return Response
         */
        public function list()
        {
            return $this->render('news/list.html.twig');
        }

        /**
         * @Route("/{slug}/", name="app.news.show")
         *
         * @return Response
         */
        public function show()
        {
            return $this->render('news/index.html.twig');
        }
    }
