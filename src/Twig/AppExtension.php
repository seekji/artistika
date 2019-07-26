<?php

    namespace App\Twig;

    use App\Service\LocationService;
    use App\Service\SettingsService;
    use Twig\Extension\AbstractExtension;
    use Twig\TwigFunction;

    class AppExtension extends AbstractExtension
    {
        /**
         * @var LocationService
         */
        private $locationService;

        /**
         * @var SettingsService $settingsService
         */
        private $settingsService;

        /**
         * AppExtension constructor.
         *
         * @param LocationService $locationService
         * @param SettingsService $settingsService
         */
        public function __construct(LocationService $locationService, SettingsService $settingsService)
        {
            $this->locationService = $locationService;
            $this->settingsService = $settingsService;
        }

        /**
         * @return array
         */
        public function getFunctions()
        {
            return [
                new TwigFunction('isUserLocationInList', [$this, 'isUserLocationInList']),
                new TwigFunction('getSiteSettingByKey', [$this, 'getSiteSettingByKey']),
            ];
        }

        /**
         * @return bool
         */
        public function isUserLocationInList()
        {
            return $this->locationService->isUserLocationInList($this->locationService->getUserLocation()) ? true : false;
        }

        /**
         * @param string $key
         * @return string|null
         */
        public function getSiteSettingByKey(string $key): ?string
        {
            return $this->settingsService->getValues()[$key] ?? null;
        }
    }