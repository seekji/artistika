<?php

namespace App\Admin;

use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\ModelListType;
use Sonata\AdminBundle\Form\Type\ModelType;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\Extension\Core\Type\ColorType;

/**
 * Class NewsAdmin
 * @package App\Admin
 */
class NewsAdmin extends AbstractAdmin
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
            ->add('isPublished')
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
        $form->with('Свойства новости')
            ->add('title');

        if ($this->isCurrentRoute('edit', 'app.admin.news')) {
            $form->add('slug');
        }

        $form
            ->add('isPublished')
            ->add('picture', ModelListType::class, ['required' => false], ['link_parameters' => ['context' => 'news']])
            ->add('description', CKEditorType::class)
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
            ->add('slug')
            ->add('description')
            ->add('isPublished')
            ->add('createdAt')
            ->add('updatedAt')
        ;
    }

}