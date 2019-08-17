<?php

namespace App\Admin\Controller;

use App\Entity\Event;
use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class EventAdminController
 * @package App\Admin\Controller
 */
class EventAdminController extends CRUDController
{
    /**
     * @param $id
     * @return RedirectResponse
     */
    public function cloneAction(int $id)
    {
        $object = $this->admin->getSubject();

        if (!$object) {
            throw new NotFoundHttpException(sprintf('Невозможно найти мероприятие с таким id: %s', $id));
        }

        /**
         * @var Event $clonedObject
         */
        $clonedObject = clone $object;

        $clonedObject->setTitle($object->getTitle().' (Копия)');
        $clonedObject->setIsActive(false);

        $object = $this->admin->create($clonedObject);

        $this->addFlash('sonata_flash_success', 'Копия успешно создана.');

        return new RedirectResponse($this->admin->generateObjectUrl('edit', $object));
    }
}