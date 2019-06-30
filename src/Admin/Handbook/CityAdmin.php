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
                ->with('Свойства города')
                    ->add('name')
                    ->add('shortName')
                    ->add('description')
                    ->add('isDefault', null, ['help' => 'Стандартный город для всех пользователей.'])
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
                ->add('shortName')
                ->add('description')
                ->add('isDefault')
                ->add('createdAt')
                ->add('updatedAt')
            ;
        }
    }
