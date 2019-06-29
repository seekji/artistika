<?php

    namespace App\Admin\Handbook;

    use Sonata\AdminBundle\Admin\AbstractAdmin;
    use Sonata\AdminBundle\Datagrid\ListMapper;
    use Sonata\AdminBundle\Form\FormMapper;

    /**
     * Class CityAdmin
     * @package App\Admin\Handbook
     */
    class CityAdmin extends AbstractAdmin
    {

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
                ->add('name')
                ->add('shortName')
                ->add('description')
                ->add('isDefault');
        }
    }
