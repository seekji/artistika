<?php

    namespace App\Controller;

    use App\Entity\News;
    use App\Service\NewsService;
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
         * @var NewsService $newsService
         */
        protected $newsService;

        /**
         * NewsController constructor.
         * @param NewsService $newsService
         */
        public function __construct(NewsService $newsService)
        {
            $this->newsService = $newsService;
        }

        /**
         * @Route("/", name="app.news.list")
         *
         * @return Response
         */
        public function list()
        {
            return $this->render('news/list.html.twig', ['news' => $this->newsService->getListOfNews()]);
        }

        /**
         * @Route("/{slug}/", name="app.news.show")
         * @param News $news
         *
         * @return Response
         */
        public function show(News $news)
        {
            if(!$news->getIsPublished()) {
                $this->createNotFoundException();
            }

            return $this->render('news/index.html.twig', ['news' => $news]);
        }
    }
