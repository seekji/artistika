<?php

    namespace App\Form\Type;

    use App\Entity\Subscribe;
    use Symfony\Component\Form\AbstractType;
    use Symfony\Component\OptionsResolver\OptionsResolver;
    use Symfony\Component\Form\Extension\Core\Type\EmailType;
    use Symfony\Component\Form\FormBuilderInterface;
    use Symfony\Component\HttpFoundation\Request;

    /**
     * Class SubscribeForm
     * @package App\Form\Type
     */
    class SubscribeForm extends AbstractType
    {
        /**
         * @param FormBuilderInterface $builder
         * @param array                $options
         */
        public function buildForm(FormBuilderInterface $builder, array $options)
        {
            $builder
                ->setMethod(Request::METHOD_POST)
                ->add('email', EmailType::class, ['required' => true])
//                ->add('city', ::class, ['required' => true])
            ;
        }

        /**
         * @param OptionsResolver $resolver
         */
        public function configureOptions(OptionsResolver $resolver)
        {
            $resolver->setDefaults(
                [
                    'data_class'         => Subscribe::class,
                    'allow_extra_fields' => true,
                    'csrf_protection'    => false,
                ]
            );
        }
    }