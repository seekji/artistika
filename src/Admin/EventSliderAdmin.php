<?php

namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\ModelListType;
use Sonata\AdminBundle\Show\ShowMapper;

/**
 * Class EventSliderAdmin
 * @package App\Admin
 */
class EventSliderAdmin extends AbstractAdmin
{

    /**
     * @param DatagridMapper $filter
     */
    protected function configureDatagridFilters(DatagridMapper $filter)
    {
        $filter
            ->add('id')
            ->add('title')
            ->add('event')
            ->add('event.city')
            ->add('isActive')
        ;
    }

    /**
     * @param ListMapper $list
     */
    protected function configureListFields(ListMapper $list)
    {
        unset($this->listModes['mosaic']);

        $list
            ->add('id')
            ->add('title')
            ->add('sort')
            ->add('event')
            ->add('event.city')
            ->add('event.startedAt')
            ->add('isActive')
            ->add('createdAt')
            ->add('updatedAt')
            ->add('_action', null, [
                'actions' => [
                    'show'   => [],
                    'edit'   => [],
                    'delete' => [],
                ],
            ]);
    }

    /**
     * @param FormMapper $form
     */
    protected function configureFormFields(FormMapper $form)
    {
        $form
            ->with('Свойства слайда')
                ->add('isActive')
                ->add('title')
                ->add('picture', ModelListType::class, [], ['link_parameters' => ['context' => 'slider']])
                ->add('event',  ModelListType::class)
                ->add('sort')
            ->end();
    }

    /**
     * @param ShowMapper $showMapper
     */
    public function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('id')
            ->add('title')
            ->add('event')
            ->add('sort')
            ->add('isActive')
            ->add('createdAt')
            ->add('updatedAt')
        ;
    }
}
