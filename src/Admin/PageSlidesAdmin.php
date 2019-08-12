<?php

namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\ModelListType;;
use Sonata\AdminBundle\Show\ShowMapper;

/**
 * Class PageSlidesAdmin
 * @package App\Admin
 */
class PageSlidesAdmin extends AbstractAdmin
{

    /**
     * @param DatagridMapper $filter
     */
    protected function configureDatagridFilters(DatagridMapper $filter)
    {
        $filter
            ->add('id')
            ->add('text')
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
            ->add('text')
            ->add('smallText')
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
                ->add('text')
                ->add('smallText')
                ->add('link', null, ['help' => 'Ссылка на страницу.'])
                ->add('picture', ModelListType::class, [], ['link_parameters' => ['context' => 'slider']])
                ->add('event',  ModelListType::class, ['required' => false])
            ->end();
    }

    /**
     * @param ShowMapper $showMapper
     */
    public function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('id')
            ->add('text')
            ->add('smallText')
            ->add('event')
            ->add('createdAt')
            ->add('updatedAt')
        ;
    }
}
