<?php

namespace App\Admin;

use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\ModelListType;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

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
        $form->tab('Свойства новости')
                ->with('Свойства', ['class' => 'col-md-9'])
                    ->add('title');

        if ($this->isCurrentRoute('edit', 'app.admin.news')) {
            $form->add('slug');
        }

        $form
                    ->add('picture', ModelListType::class, ['required' => false], ['link_parameters' => ['context' => 'news']])
                    ->add('previewDescription', TextareaType::class)
                    ->add('description', CKEditorType::class)
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
            ->add('description')
            ->add('previewDescription')
            ->add('isPublished')
            ->add('createdAt')
            ->add('updatedAt')
        ;
    }

}