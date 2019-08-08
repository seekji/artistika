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
         * @Rest\Route("/list/", methods={"GET"})
         *
         * @param Request $request
         * @return JsonResponse
         */
        public function list(Request $request)
        {
            $query  = (string) $request->get('query');

            if(strlen($query) < 2) {
                return new JsonResponse([], JsonResponse::HTTP_OK, []);
            }

            return new JsonResponse(['events' => $this->eventService->searchEvents($query)], JsonResponse::HTTP_OK, []);
        }
    }
