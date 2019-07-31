<?php

namespace App\Service;

use App\Repository\NewsRepository;

/**
 * Class NewsService
 * @package App\Service
 */
class NewsService
{
    /**
     * @var NewsRepository
     */
    protected $newsRepository;

    /**
     * NewsService constructor.
     * @param NewsRepository $newsRepository
     */
    public function __construct(NewsRepository $newsRepository)
    {
        $this->newsRepository = $newsRepository;
    }

    /**
     * @param int $offset
     * @param int $limit
     *
     * @return null|array
     */
    public function getListOfNews(int $offset = 0, int $limit = 50): ?array
    {
        return $this->newsRepository->getListOfNews($offset, $limit);
    }
}