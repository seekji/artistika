<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;

/**
 * Class ContentService
 * @package App\Service
 */
class ContentService
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param $entity
     * @param $slug
     * @return string
     */
    public function createUniqueSlug($entity, $slug): string
    {
        $countEntities = 0;
        $entitySlug = $this->entityManager->createQueryBuilder()
            ->select('entity.slug')
            ->from($entity, 'entity')
            ->where('entity.slug LIKE :slug')
            ->setParameter('slug', "{$slug}%")
            ->orderBy('entity.slug', 'DESC')
            ->andHaving('count(entity.slug) > 0')
            ->groupBy('entity.slug')
            ->setMaxResults(1)
            ->getQuery()
            ->getResult();

        if (isset($entitySlug[0]['slug']) && !empty($entitySlug[0]['slug'])) {
            $pieces = explode('-', $entitySlug[0]['slug']);
            $countEntities = intval(end($pieces)) + 1;
        }

        return $countEntities > 0 ? sprintf('%s-%d', $this->cleanSlug($slug), $countEntities) : $slug;
    }

    /**
     * @param string $slug
     * @return string
     */
    private function cleanSlug(string $slug): string
    {
        return preg_replace("/[^A-Za-z-]/", "", $slug);
    }
}