<?php

    namespace App\Controller\Api;

    use App\Service\EventService;
    use Symfony\Component\HttpFoundation\Request;
    use FOS\RestBundle\Controller\AbstractFOSRestController;
    use FOS\RestBundle\Controller\Annotations as Rest;
    use Symfony\Component\HttpFoundation\JsonResponse;
    use JMS\Serializer\SerializerInterface;

    /**
     * Class SearchController
     * @package App\Controller\Api
     * @Rest\Route("/api/search")
     */
    class SearchController extends AbstractFOSRestController
    {
        /**
         * @var EventService
         */
        protected $eventService;

        /**
         * SearchController constructor.
         * @param EventService $eventService
         */
        public function __construct(EventService $eventService)
        {
            $this->eventService = $eventService;
        }

        /**
         * @Rest\Route("/list/", name="app.search.list", methods={"GET"})
         *
         * @param Request $request
         * @return JsonResponse
         */
        public function list(Request $request)
        {
            $query  = preg_replace('/[^a-zA-Z0-9]/', "", (string) $request->get('query'));

            if(strlen($query) < 2) {
                return new JsonResponse([], JsonResponse::HTTP_OK, []);
            }

            return new JsonResponse(['result' => $this->renderView('event/__search_result.html.twig', [
                'events' => $this->eventService->searchEvents($query)
            ])], JsonResponse::HTTP_OK, []);
        }
    }
