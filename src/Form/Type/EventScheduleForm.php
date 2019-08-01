<?php

namespace App\Form\Type;

use App\Entity\EventSchedule;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Class EventScheduleForm
 * @package App\Form\Type
 */
class EventScheduleForm extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('time', TimeType::class, ['required' => true])
            ->add('tickets', TextType::class, ['required' => true])
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class'         => EventSchedule::class,
                'allow_extra_fields' => true,
            ]
        );
    }
}