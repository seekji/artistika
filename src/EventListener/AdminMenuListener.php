<?php

namespace App\EventListener;

use Sonata\AdminBundle\Event\ConfigureMenuEvent;

class AdminMenuListener
{
    public function addMenuItems(ConfigureMenuEvent $event)
    {
        $menu = $event->getMenu();

        $menu
            ->addChild('reports', [ 'label' => 'Настройки сайта', 'route' => 'admin.site.settings.edit'])
            ->setExtras(['icon' => '<i class="fa fa-cogs"></i>']);
    }
}