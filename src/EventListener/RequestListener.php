<?php

    namespace App\EventListener;

    use App\Service\LocationService;
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
         * RequestListener constructor.
         *
         * @param LocationService $locationService
         * @param SessionInterface $session
         */
        public function __construct(LocationService $locationService, SessionInterface $session)
        {
            $this->locationService = $locationService;
            $this->session = $session;
        }

        public function onKernelRequest(RequestEvent $event)
        {
            if (!$event->isMasterRequest()) {
                return;
            }

            /**
             * trying to get user location by his ip address.
             */
            if(!$this->session->has(LocationService::SESSION_LOCATION)) {
                $this->locationService->getUserLocation();
            }
        }
    }