<?php

    namespace App\Admin;

    use App\Entity\EventSchedule;
    use App\Form\Type\EventScheduleForm;
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
     * Class HallAdmin
     * @package App\Admin
     */
    class EventAdmin extends AbstractAdmin
    {

        /**
         * @param DatagridMapper $filter
         */
        protected function configureDatagridFilters(DatagridMapper $filter)
        {
            $filter
                ->add('id')
                ->add('title')
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
                ->add('city')
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
                ->tab('Основные свойства мероприятия')
                    ->with('Основные свойства мероприятия', ['class' => 'col-md-9'])
                        ->add('title')
                        ->add('isActive')
                        ->add('isCanceled')
            ;

            if ($this->isCurrentRoute('edit', 'app.admin.event')) {
                $form->add('slug');
            }

            $form
                    ->add('artist',  TextType::class)
                    ->add('city',  ModelListType::class)
                    ->add('hall', ModelListType::class)
                ->end()
                ->with('Теги', ['class' => 'col-md-3'])
                    ->add('tags', ModelType::class, ['multiple' => true])
                ->end()
                ->end()
                ->tab('Описание и визуал')
                    ->with('Описание и визуал')
                        ->add('color', ColorType::class)
                        ->add('isPreviewBig')
                        ->add('description', CKEditorType::class)
                        ->add('picture', ModelListType::class, [], ['link_parameters' => ['context' => 'events']])
                        ->add('bigPicture', ModelListType::class, [], ['link_parameters' => ['context' => 'events']])
                    ->end()
                ->end()
                ->tab('Время')
                    ->with('Время')
                        ->add('startedAt')
                        ->add('tickets', CollectionType::class, [
                            'by_reference' => false, // Use this because of reasons
                            'allow_add' => true, // True if you want allow adding new entries to the collection
                            'allow_delete' => true, // True if you want to allow deleting entries
                            'prototype' => true, // True if you want to use a custom form type
                            'entry_type' => EventScheduleForm::class, // Form type for the Entity that is being attached to the object
                        ])
                    ->end()
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
                ->add('city')
                ->add('hall')
                ->add('createdAt')
                ->add('updatedAt')
            ;
        }
    }
