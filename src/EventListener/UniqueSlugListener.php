<?php

namespace App\EventListener;

use App\Service\ContentService;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Doctrine\ORM\Events;

/**
 * Class UniqueSlugListener
 * @package App\EventListener
 */
class UniqueSlugListener
{
    /**
     * @var ContentService
     */
    private $contentService;

    /**
     * UniqueSlugListener constructor.
     * @param ContentService $contentService
     */
    public function __construct(ContentService $contentService)
    {
        $this->contentService = $contentService;
    }

    /**
     * @param LifecycleEventArgs $args
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getObject();

        if(!method_exists($entity, 'getSlug')) {
            return;
        }

        $entity->setSlug($this->contentService->createUniqueSlug(get_class($entity), $entity->getSlug()));
    }
}
