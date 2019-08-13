<?php

    namespace App\Admin;

    use Sonata\AdminBundle\Admin\AbstractAdmin;
    use Sonata\AdminBundle\Datagrid\DatagridMapper;
    use Sonata\AdminBundle\Datagrid\ListMapper;
    use Sonata\AdminBundle\Form\FormMapper;
    use Sonata\AdminBundle\Show\ShowMapper;

    /**
     * Class HallAdmin
     * @package App\Admin\Handbook
     */
    class SubscribeAdmin extends AbstractAdmin
    {

        /**
         * @param DatagridMapper $filter
         */
        protected function configureDatagridFilters(DatagridMapper $filter)
        {
            $filter
                ->add('id')
                ->add('email')
                ->add('city')
                ->add('mailchimpId')
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
                ->add('email')
                ->add('city')
                ->add('mailchimpId')
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
                ->with('Свойства подписки')
                    ->add('email')
                    ->add('city')
                ->end();
        }

        /**
         * @param ShowMapper $showMapper
         */
        public function configureShowFields(ShowMapper $showMapper)
        {
            $showMapper
                ->add('id')
                ->add('email')
                ->add('city')
                ->add('mailchimpId')
                ->add('createdAt')
                ->add('updatedAt')
            ;
        }
    }
