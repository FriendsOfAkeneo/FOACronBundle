<?php

namespace FOA\CronBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Cron job form type
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
            ->add('logFile', 'text', [
                'required' => false,
            ])
            ->add('errorFile', 'text', [
                'required' => false,
            ])
            ->add('comment', 'text', [
                'required' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'FOA\CronBundle\Manager\Cron'
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
