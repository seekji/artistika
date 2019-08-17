<?php

    namespace App\Admin\Handbook;

    use Sonata\AdminBundle\Admin\AbstractAdmin;
    use Sonata\AdminBundle\Datagrid\DatagridMapper;
    use Sonata\AdminBundle\Datagrid\ListMapper;
    use Sonata\AdminBundle\Form\FormMapper;
    use Sonata\AdminBundle\Show\ShowMapper;

    /**
     * Class CityAdmin
     * @package App\Admin\Handbook
     */
    class CityAdmin extends AbstractAdmin
    {

        /**
         * @param DatagridMapper $filter
         */
        protected function configureDatagridFilters(DatagridMapper $filter)
        {
            $filter
                ->add('id')
                ->add('name')
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
                ->add('name')
                ->add('isDefault')
                ->add('isMain')
                ->add('sort')
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
            $form->tab('Основные свойства')
                ->with('Свойства')
                    ->add('name')
                    ->add('sort')
                    ->add('isMain')
                    ->add('isDefault', null, ['help' => 'Стандартный город для всех пользователей.']);

            if ($this->isCurrentRoute('edit', 'app.admin.handbook.city')) {
                $form->add('slug');
            }

            $form->end();

            $form
                ->with('Тексты')
                    ->add('tagText', null, ['help' => 'Текст для тегов.'])
                    ->add('subscribeText', null, ['help' => 'Текст для формы с подпиской.'])
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
                ->add('name')
                ->add('subscribeText')
                ->add('tagText')
                ->add('isDefault')
                ->add('isMain')
                ->add('createdAt')
                ->add('updatedAt')
            ;
        }
    }
