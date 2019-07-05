<?php

    namespace App\Controller\Api;

    use App\Model\Location;
    use App\Service\LocationService;
    use FOS\RestBundle\Controller\AbstractFOSRestController;
    use FOS\RestBundle\Controller\Annotations as Rest;
    use Symfony\Component\HttpFoundation\JsonResponse;
    use Symfony\Component\HttpFoundation\Request;
    use Symfony\Component\Routing\Annotation\Route;

    /**
     * Movie controller.
     * @Route("/api/user-location", name="api.user-location")
     */
    class UserLocationController extends AbstractFOSRestController
    {
        /**
         * @var LocationService $locationService
         */
        private $locationService;

        /**
         * UserLocationController constructor.
         *
         * @param LocationService $locationService
         */
        public function __construct(LocationService $locationService)
        {
            $this->locationService = $locationService;
        }

        /**
         * @Rest\Post("/save")
         *
         * @param Request $request
         *
         * @return \Symfony\Component\HttpFoundation\JsonResponse
         */
        public function save(Request $request)
        {
            if($request->get('city') === null || empty($request->get('city'))) {
                return $this->json(['status' => 'error', 'message' => 'Field `city` cannot be empty.'], JsonResponse::HTTP_BAD_REQUEST);
            }

            $location = new Location();
            $location->setCity($request->get('city'));

            if($this->locationService->isUserLocationInList($location)) {
                $this->locationService->setUserLocation($location);

                return $this->json(['status' => 'success', 'message' => 'Location successfully updated.']);
            }

            return $this->json(['status' => 'error', 'message' => 'Location is not in allowed list.'], JsonResponse::HTTP_BAD_REQUEST);
        }

    }