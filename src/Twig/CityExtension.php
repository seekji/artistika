<?php

    namespace App\Twig;

    use App\Entity\Handbook\City;
    use App\Service\CityService;
    use Twig\Extension\AbstractExtension;
    use Twig\TwigFunction;

    class CityExtension extends AbstractExtension
    {
        /**
         * @var CityService $cityService
         */
        private $cityService;

        /**
         * CityExtension constructor.
         *
         * @param CityService $cityService
         */
        public function __construct(CityService $cityService)
        {
            $this->cityService = $cityService;
        }

        /**
         * @return array
         */
        public function getFunctions()
        {
            return [
                new TwigFunction('getCitiesList', [$this, 'getCitiesList']),
                new TwigFunction('getDefaultCity', [$this, 'getDefaultCity']),
            ];
        }

        /**
         * @return array
         */
        public function getCitiesList(): array
        {
            return $this->cityService->getCitiesList();
        }

        /**
         * @return City|null
         */
        public function getDefaultCity(): ?City
        {
            return $this->cityService->getDefaultCity();
        }
    }