<?php

namespace App\Service;

use App\Entity\Handbook\City;
use App\Repository\Handbook\CityRepository;

/**
 * Class CityService
 * @package App\Service
 */
class CityService
{
    /**
     * @var CityRepository
     */
    protected $cityRepository;

    /**
     * CityService constructor.
     * @param CityRepository $cityRepository
     */
    public function __construct(CityRepository $cityRepository)
    {
        $this->cityRepository = $cityRepository;
    }

    /**
     * @return City|null
     */
    public function getDefaultCity(): ?City
    {
        return $this->cityRepository->findOneBy(['isDefault' => true]);
    }

    /**
     * @return array
     */
    public function getCitiesList(): array
    {
        return $this->cityRepository->findBy([], ['isDefault' => 'DESC', 'isMain' => 'DESC', 'sort' => 'ASC', 'name' => 'ASC']);
    }
}