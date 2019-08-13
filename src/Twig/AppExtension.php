<?php

    namespace App\Twig;

    use App\Service\LocationService;
    use App\Service\MenuService;
    use App\Service\SettingsService;
    use Twig\Extension\AbstractExtension;
    use Twig\TwigFunction;
    use Twig\TwigFilter;

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
         * @var MenuService $menuService
         */
        private $menuService;

        /**
         * AppExtension constructor.
         *
         * @param LocationService $locationService
         * @param SettingsService $settingsService
         * @param MenuService $menuService
         */
        public function __construct(LocationService $locationService, SettingsService $settingsService, MenuService $menuService)
        {
            $this->locationService = $locationService;
            $this->settingsService = $settingsService;
            $this->menuService     = $menuService;
        }

        /**
         * @return array
         */
        public function getFunctions()
        {
            return [
                new TwigFunction('isUserLocationInList', [$this, 'isUserLocationInList']),
                new TwigFunction('getSiteSettingByKey', [$this, 'getSiteSettingByKey']),
                new TwigFunction('getActiveMenuItems', [$this, 'getActiveMenuItems']),
            ];
        }

        /**
         * @return array|TwigFilter[]
         */
        public function getFilters()
        {
            return [
                new TwigFilter('phoneHref', [$this, 'phoneHref']),
            ];
        }

        /**
         * @param $phone
         * @return string|string[]|null
         */
        public function phoneHref($phone)
        {
            return preg_replace('/[^0-9]/', '', $phone);
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

        /**
         * @return array
         */
        public function getActiveMenuItems(): array
        {
            return $this->menuService->getActiveItems();
        }
    }