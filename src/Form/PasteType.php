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
            ->add('lang', ChoiceType::class, ['choices' => ['php' => 'php', 'javascript' => 'javascript', 'go' => 'go']])
            ->add('expiration_time', ChoiceType::class, ['choices' => [
                '10 min' => 10,
                '1 hour' => 60,
                '3 hours' => 180,
                '1 day' => 24 * 60,
                '1 week' => 24 * 60 * 7,
                '1 month' => 24 * 60 * 30,
                'unlimited' => 0
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
