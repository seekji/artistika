<?php

    namespace App\Service;

    use Symfony\Component\HttpFoundation\Cookie;
    use Doctrine\ORM\EntityManagerInterface;
    use seekji\GeoIpBundle\LocationProvider\MaxmindLocationProvider;
    use App\Entity\Handbook\City;
    use App\Model\Location;
    use Symfony\Component\HttpFoundation\RequestStack;

    /**
     * Class LocationService
     * @package App\Service
     */
    class LocationService
    {
        /**
         * Session variable name for location
         */
        const COOKIE_VALUE_NAME = 'site.user_location';

        /**
         * @var Location $userLocation
         */
        private $userLocation;

        /**
         * @var \seekji\GeoIpBundle\LocationProvider\MaxmindLocationProvider|object
         */
        private $maxmindProvider;

        /**
         * @var EntityManagerInterface $entityManager
         */
        private $entityManager;

        /**
         * @var RequestStack $requestStack
         */
        private $requestStack;

        /**
         * LocationService constructor.
         *
         * @param RequestStack $requestStack
         * @param MaxmindLocationProvider $provider
         * @param EntityManagerInterface  $entityManager
         */
        public function __construct(RequestStack $requestStack, MaxmindLocationProvider $provider, EntityManagerInterface $entityManager)
        {
            $this->maxmindProvider = $provider;
            $this->entityManager   = $entityManager;
            $this->requestStack    = $requestStack;
        }

        /**
         * @return Location|null
         */
        public function getUserLocation(): ?Location
        {
            if (empty($this->userLocation)) {
                if ($this->requestStack->getMasterRequest()->cookies->has(self::COOKIE_VALUE_NAME)) {
                    $this->userLocation = unserialize($this->requestStack->getMasterRequest()->cookies->get(self::COOKIE_VALUE_NAME));

                    return $this->userLocation;
                }

                if ($location = $this->findUserLocation()) {
                    $this->setUserLocation($location);
                }
            }

            return $this->userLocation;
        }

        /**
         * Find location in binary by user ip address.
         *
         * @return Location|null
         */
        public function findUserLocation(): ?Location
        {
            try {
                $location = new Location();
                $result = $this->maxmindProvider->findLocationInBinary($this->requestStack->getMasterRequest()->getClientIp());

                if (isset($result->city->names['ru'])) {
                    $location->setCity($result->city->names['ru']);
                }

                if (isset($result->subdivisions[0]->names['ru'])) {
                    $location->setRegion($result->subdivisions[0]->names['ru']);
                }

                return $location;
            } catch (\Exception $exception) {
                // todo: log exceptions.
                return null;
            }
        }

        /**
         * @param Location $location
         *
         * @return self
         */
        public function setUserLocation(Location $location): self
        {
            if (empty($location) || !$location instanceof Location) {
                throw new \LogicException('Location cannot be empty.');
            }

            $cookie = new Cookie(self::COOKIE_VALUE_NAME, serialize($location), strtotime('1 year'));

//            $this->requestStack->getMasterRequest()->cookies->set(, , );
            $this->userLocation = $location;

            return $this;
        }

        /**
         * Check user location in available list of cities/regions.
         *
         * @param Location $location
         *
         * @return bool
         */
        public function isUserLocationInList(Location $location): bool
        {
            if ($location instanceof Location and $location->getCity()) {
                $city = $this->entityManager->getRepository(City::class)->findOneBy([ 'name' => $location->getCity() ]);

                return $city instanceof City ? true : false;
            }

            return false;
        }

        /**
         * @return City
         */
        public function getCityByUserCookie(): City
        {
            return $this->entityManager->getRepository(City::class)->getCityByCookieOrDefault($this->getUserLocation()->getCity());
        }
    }