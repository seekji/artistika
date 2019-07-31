<?php

    namespace App\Admin;

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
                        ->add('title');

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
                    ->end()
                ->end()
                ->tab('Время')
                    ->with('Время')
                        ->add('startedAt')
                        ->add('times', CollectionType::class, [
                            'entry_type' => TimeType::class,
                            'allow_add' => true,
                            'allow_delete' => true,
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
