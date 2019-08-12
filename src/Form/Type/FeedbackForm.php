<?php

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Email;

/**
 * Class FeedbackForm
 * @package App\Form\Type
 */
class FeedbackForm extends AbstractType
{

    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('reason', TextType::class, ['label' => 'FIO', 'required' => true])
            ->add('name', TextType::class, ['required' => true, 'constraints' => [new NotBlank(['message' => 'name.not_blank'])]])
            ->add('smi_link', TextType::class, ['required' => false])
            ->add('artist_name', TextType::class, ['required' => false])
            ->add('event_format', TextType::class, ['required' => false])
            ->add('email', EmailType::class, ['required' => true,  'constraints' => [new Email(['message' => 'email.email']), new NotBlank(['message' => 'email.not_blank'])]])
            ->add('phone', TextType::class, ['required' => true, 'constraints' => [new NotBlank(['message' => 'phone.not_blank'])]])
            ->add('comment', TextType::class, ['required' => false])
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class'         => null,
                'allow_extra_fields' => true,
                'csrf_protection'    => false,
            ]
        );
    }
}
