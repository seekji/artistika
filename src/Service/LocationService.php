<?php

    namespace App\Service;

    use Symfony\Component\HttpFoundation\Request;
    use Symfony\Component\HttpFoundation\Session\SessionInterface;
    use Doctrine\ORM\EntityManagerInterface;
    use seekji\GeoIpBundle\LocationProvider\MaxmindLocationProvider;
    use App\Entity\Handbook\City;
    use App\Model\Location;

    /**
     * Class LocationService
     * @package App\Service
     */
    class LocationService
    {
        /**
         * Session variable name for location
         */
        const SESSION_LOCATION = 'site.user_location';

        /**
         * @var SessionInterface $session
         */
        private $session;

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
         * LocationService constructor.
         *
         * @param SessionInterface        $session
         * @param MaxmindLocationProvider $provider
         * @param EntityManagerInterface  $entityManager
         */
        public function __construct(SessionInterface $session, MaxmindLocationProvider $provider, EntityManagerInterface $entityManager)
        {
            $this->session         = $session;
            $this->maxmindProvider = $provider;
            $this->entityManager   = $entityManager;
        }

        /**
         * @return Location|null
         */
        public function getUserLocation(): ?Location
        {
            if (empty($this->userLocation)) {
                if ($this->session->has(self::SESSION_LOCATION)) {
                    $this->userLocation = unserialize($this->session->get(self::SESSION_LOCATION));

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
                $result = $this->maxmindProvider->findLocationInBinary('109.205.253.39');

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
         * @return void
         */
        public function setUserLocation(Location $location): void
        {
            if (empty($location) || !$location instanceof Location) {
                throw new \LogicException('Location cannot be empty.');
            }

            $this->session->set(self::SESSION_LOCATION, serialize($location));
            $this->userLocation = $location;
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

    }