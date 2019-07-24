<?php

    namespace App\Admin\Classification;

    use Sonata\AdminBundle\Admin\AbstractAdmin;
    use Sonata\AdminBundle\Datagrid\DatagridMapper;
    use Sonata\AdminBundle\Datagrid\ListMapper;
    use Sonata\AdminBundle\Form\FormMapper;
    use Sonata\AdminBundle\Form\Type\ModelAutocompleteType;
    use Sonata\AdminBundle\Show\ShowMapper;

    /**
     * Class TagAdmin
     * @package App\Admin\Classification
     */
    class TagAdmin extends AbstractAdmin
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
            $form->with('Свойства тэга')->add('title');

            if ($this->isCurrentRoute('edit', 'app.admin.classification.tag')) {
                $form->add('slug');
            }

            $form->end();
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
                ->add('createdAt')
                ->add('updatedAt')
            ;
        }
    }
