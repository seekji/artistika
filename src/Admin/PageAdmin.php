<?php

namespace App\Admin;

use App\Entity\Page;

use App\Entity\PageSlides;
use App\Form\Type\EventScheduleForm;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\ChoiceFieldMaskType;
use Sonata\AdminBundle\Form\Type\ModelType;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\Form\Type\CollectionType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Sonata\AdminBundle\Form\Type\AdminType;

/**
 * Class PageAdmin
 * @package App\Admin
 */
class PageAdmin extends AbstractAdmin
{
    /**
     * @param DatagridMapper $filter
     */
    protected function configureDatagridFilters(DatagridMapper $filter)
    {
        $filter
            ->add('id')
            ->add('title')
            ->add('slug')
            ->add('isPublished')
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
            ->add('slug')
            ->add('template', 'choice', ['choices' => Page::TEMPLATES])
            ->add('createdAt')
            ->add('updatedAt')
            ->add('isPublished')
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
        $form->tab('Свойства страницы')
            ->with('Свойства', ['class' => 'col-md-9'])
                ->add('title');

        if ($this->isCurrentRoute('edit', 'app.admin.page')) {
            $form->add('slug', null, ['required' => true]);
        }

        $form
                ->add('template', ChoiceFieldMaskType::class, [
                    'choices' => array_flip(Page::TEMPLATES),
                    'map' => [
                        Page::TEMPLATE_STATIC => [],
                        Page::TEMPLATE_CONTACTS => [],
                        Page::TEMPLATE_ABOUT => ['slides'],
                    ],
                    'required' => true
                ])
                ->add('text', CKEditorType::class)
                ->add('slides', ModelType::class, ['multiple' => true, 'required' => false])
            ->end()
            ->with('Состояние', ['class' => 'col-md-3'])
                ->add('isPublished')
            ->end()
        ->end()
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    public function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('id')
            ->add('title')
            ->add('slug')
            ->add('text')
            ->add('template')
            ->add('isPublished')
            ->add('createdAt')
            ->add('updatedAt')
        ;
    }

}