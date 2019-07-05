<?php

    namespace App\Twig;

    use App\Service\LocationService;
    use Twig\Extension\AbstractExtension;
    use Twig\TwigFunction;

    class AppExtension extends AbstractExtension
    {
        /**
         * @var LocationService
         */
        private $locationService;

        /**
         * AppExtension constructor.
         *
         * @param LocationService $locationService
         */
        public function __construct(LocationService $locationService)
        {
            $this->locationService = $locationService;
        }

        /**
         * @return array
         */
        public function getFunctions()
        {
            return [
                new TwigFunction('isUserLocationInList', [$this, 'isUserLocationInList'])
            ];
        }

        /**
         * @return bool
         */
        public function isUserLocationInList()
        {
            return $this->locationService->isUserLocationInList($this->locationService->getUserLocation()) ? true : false;
        }
    }