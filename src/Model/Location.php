<?php

    namespace App\Model;

    class Location
    {
        /**
         * @var string $city
         */
        protected $city;

        /**
         * @var string $region
         */
        protected $region;

        /**
         * @return string
         */
        public function getCity(): string
        {
            return $this->city;
        }

        /**
         * @param string $city
         */
        public function setCity(string $city)
        {
            $this->city = $city;
        }

        /**
         * @return string
         */
        public function getRegion(): string
        {
            return $this->region;
        }

        /**
         * @param string $region
         */
        public function setRegion(string $region)
        {
            $this->region = $region;
        }
    }