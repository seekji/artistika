<?php

namespace App\Service;

use App\Repository\MenuRepository;

/**
 * Class MenuService
 * @package App\Service
 */
class MenuService
{
    /**
     * @var MenuRepository $menuRepository
     */
    protected $menuRepository;

    /**
     * MenuService constructor.
     * @param MenuRepository $menuRepository
     */
    public function __construct(MenuRepository $menuRepository)
    {
        $this->menuRepository = $menuRepository;
    }

    /**
     * @return array
     */
    public function getActiveItems(): array
    {
        return $this->menuRepository->findBy(['isActive' => true], ['sort' => 'ASC']);
    }
}