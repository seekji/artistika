<?php

    namespace App\Controller;

    use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
    use App\Entity\Page;
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
         * @param Page $page
         * @return Response
         */
        public function show(Page $page)
        {
            if(!$page->getIsPublished()) {
                throw $this->createNotFoundException();
            }

            $template = Page::TEMPLATES[$page->getTemplate()];

            return $this->render("page/{$template}.html.twig", ['page' => $page]);
        }
    }
