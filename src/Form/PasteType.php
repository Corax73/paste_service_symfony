<?php

namespace App\Form;

use App\Entity\Paste;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class PasteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title')
            ->add('expiration_time', ChoiceType::class, ['choices' => [
                '10 min' => '10 min',
                '1 hour' => '1 hour',
                '3 hours' => '3 hours',
                '1 day' => '1 day',
                '1 week' => '1 week',
                '1 month' => '1 month',
                'unlimited' => 'unlimited'
            ]])
            ->add('access', ChoiceType::class, ['choices' => ['public' => 'public', 'unlisted' => 'unlisted', 'private' => 'private']])
            ->add('text')
            ->setAction($options['action'])
            ->setMethod('POST')
            ->add('save', SubmitType::class, ['label' => 'Save paste'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Paste::class,
        ]);
    }
}
