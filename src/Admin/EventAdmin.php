<?php

    namespace App\Admin;

    use App\Form\Type\EventScheduleForm;
    use FOS\CKEditorBundle\Form\Type\CKEditorType;
    use Sonata\AdminBundle\Admin\AbstractAdmin;
    use Sonata\AdminBundle\Datagrid\DatagridMapper;
    use Sonata\AdminBundle\Datagrid\ListMapper;
    use Sonata\AdminBundle\Form\FormMapper;
    use Sonata\AdminBundle\Form\Type\ModelListType;
    use Sonata\AdminBundle\Form\Type\ModelType;
    use Sonata\Form\Type\DatePickerType;
    use Sonata\AdminBundle\Show\ShowMapper;
    use Sonata\Form\Type\ImmutableArrayType;
    use Symfony\Component\Form\Extension\Core\Type\CollectionType;
    use Symfony\Component\Form\Extension\Core\Type\TextType;
    use Symfony\Component\Form\Extension\Core\Type\ColorType;

    /**
     * Class EventAdmin
     * @package App\Admin
     */
    class EventAdmin extends AbstractAdmin
    {

        /**
         * @param array $actions
         * @return array
         */
        protected function configureBatchActions($actions)
        {
            if(isset($actions['delete'])) {
                unset($actions['delete']);
            }

            return $actions;
        }

        /**
         * @param DatagridMapper $filter
         */
        protected function configureDatagridFilters(DatagridMapper $filter)
        {
            $filter
                ->add('id')
                ->add('title')
                ->add('artist')
                ->add('startedAt')
                ->add('city')
                ->add('hall')
                ->add('slug')
                ->add('isActive')
                ->add('isCanceled')
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
                ->add('artist')
                ->add('city')
                ->add('hall')
                ->add('startedAt')
                ->add('slug')
                ->add('isCanceled')
                ->add('isActive')
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
                        ->add('artist',  TextType::class)
            ;

            if ($this->isCurrentRoute('edit', 'app.admin.event')) {
                $form->add('slug');
            }

            $form
                    ->add('city',  ModelListType::class)
                    ->add('hall', ModelListType::class)
                ->end()
                ->with('Состояние', ['class' => 'col-md-3'])
                    ->add('isActive')
                    ->add('isCanceled')
                ->end()
                ->with('Теги', ['class' => 'col-md-3'])
                    ->add('tags', ModelType::class, ['multiple' => true])
                ->end()
                ->end()
                ->tab('Описание')
                    ->with('Описание')
                        ->add('additionalText')
                        ->add('description', CKEditorType::class)
                    ->end()
                ->end()
                ->tab('Визуал')
                    ->with('Картинки', ['class' => 'col-md-9'])
                        ->add('picture', ModelListType::class, ['label' => 'Маленькая картинка для списка', 'required' => false], ['link_parameters' => ['context' => 'events']])
                        ->add('bigPicture', ModelListType::class,
                            ['label' => 'Большая картинка для списка', 'help' => 'Необходимо отметить состояние для отображения.', 'required' => false],
                            ['link_parameters' => ['context' => 'events']]
                        )
                        ->add('detailPicture', ModelListType::class, ['label' => 'Картинка для детальной страницы', 'required' => false], ['link_parameters' => ['context' => 'events']]
                        )
                    ->end()
                    ->with('Состояние', ['class' => 'col-md-3'])
                        ->add('color', ColorType::class, ['help' => 'Основной цвет детальной страницы.'])
                        ->add('isPreviewBig', null, ['help' => 'Отображение мероприятия в списке.'])
                    ->end()
                ->end()
                ->tab('Время')
                    ->with('Время')
                        ->add('startedAt', DatePickerType::class)
                        ->add('tickets', CollectionType::class, [
                            'by_reference' => false,
                            'allow_add' => true,
                            'allow_delete' => true,
                            'prototype' => true,
                            'entry_type' => EventScheduleForm::class,
                        ])
                    ->end()
                ->end()
                ->tab('Остальное')
                    ->with('Остальное')
                        ->add('age')
                        ->add('social_links', ImmutableArrayType::class, [
                            'keys' => [
                                ['vk', TextType::class, ['required' => false]],
                                ['facebook', TextType::class, ['required' => false]],
                            ],
                            'required' => false
                        ])
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
                ->add('artist')
                ->add('tags')
                ->add('city')
                ->add('hall')
                ->add('slug')
                ->add('startedAt')
                ->add('createdAt')
                ->add('updatedAt')
            ;
        }
    }
