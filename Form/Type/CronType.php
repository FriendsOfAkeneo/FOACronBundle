<?php

namespace FOA\CronBundle\Form\Type;

use FOA\CronBundle\Manager\Cron;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Cron job form type
 *
 * @author Novikov Viktor
 */
class CronType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('minute')
            ->add('hour')
            ->add('dayOfMonth')
            ->add('month')
            ->add('dayOfWeek')
            ->add('command')
            ->add('logFile', TextType::class, [
                'required' => false,
            ])
            ->add('errorFile', TextType::class, [
                'required' => false,
            ])
            ->add('comment', TextType::class, [
                'required' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Cron::class
        ]);
    }

    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return 'cron';
    }
}
