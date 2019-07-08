<?php

    namespace App\EventListener;

    use App\Service\LocationService;
    use Symfony\Component\HttpFoundation\RequestStack;
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
         * @var RequestStack $requestStack
         */
        private $requestStack;

        /**
         * RequestListener constructor.
         *
         * @param LocationService $locationService
         * @param RequestStack $requestStack
         */
        public function __construct(LocationService $locationService, RequestStack $requestStack)
        {
            $this->locationService = $locationService;
            $this->requestStack = $requestStack;
        }

        public function onKernelRequest(RequestEvent $event)
        {
            if (!$event->isMasterRequest()) {
                return;
            }

            /**
             * trying to get user location by his ip address.
             * todo: set user cookie.
             */
//            if(!$this->requestStack->getMasterRequest()->cookies->has(LocationService::COOKIE_VALUE_NAME)) {
//                $this->locationService->getUserLocation();
//            }
        }
    }