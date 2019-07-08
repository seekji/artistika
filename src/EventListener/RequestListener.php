<?php

    namespace App\EventListener;

    use App\Entity\Handbook\City;
    use App\Model\Location;
    use App\Service\LocationService;
    use Doctrine\ORM\EntityManagerInterface;
    use Symfony\Component\HttpFoundation\Session\SessionInterface;
    use Symfony\Component\HttpKernel\Event\RequestEvent;

    /**
     * Class RequestListener
     * @package App\EventListener
     */
    class RequestListener
    {
        /**
         * @var LocationService $locationService
         */
        private $locationService;

        /**
         * @var SessionInterface $session
         */
        private $session;

        /**
         * @var EntityManagerInterface $entityManager
         */
        private $entityManager;

        /**
         * RequestListener constructor.
         *
         * @param LocationService $locationService
         * @param SessionInterface $session
         * @param EntityManagerInterface $entityManager
         */
        public function __construct(LocationService $locationService, SessionInterface $session, EntityManagerInterface $entityManager)
        {
            $this->locationService = $locationService;
            $this->session         = $session;
            $this->entityManager   = $entityManager;
        }

        public function onKernelRequest(RequestEvent $event)
        {
            if (!$event->isMasterRequest()) {
                return;
            }

            /**
             * trying to get user location by his ip address.
             */
//            if(!$this->session->has(LocationService::SESSION_LOCATION)) {
//                $location = $this->locationService->getUserLocation();
//
//                if ($location === null) {
//
//                    $defaultCity = $this->entityManager->getRepository(City::class)->findOneBy([ 'isDefault' => true ]);
//
//                    $location->setCity($defaultCity->getName());
//                    $this->locationService->setUserLocation($location);
//                }
//            }
        }
    }