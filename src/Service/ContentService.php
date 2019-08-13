<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;

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
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function createUniqueSlug($entity, $slug): string
    {
        $countEntities = (int) $this->entityManager->createQueryBuilder()
            ->select('count(object.id)')
            ->from($entity, 'object')
            ->where('object.slug = :slug')
            ->setParameter('slug', $slug)
            ->getQuery()
            ->getSingleScalarResult();

        return $countEntities > 0 ? sprintf('%s-%d', $slug, $countEntities + 1) : $slug;
    }
}