<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType; 
use App\Entity\Trajet;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\DateType;


class FilterTrajetType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('depart', EntityType::class, [
                'class' => Trajet::class,
                'placeholder' => 'selectionner',
                'choice_label' => 'depart',
                'choice_value' => 'depart',
                'autocomplete' => true
            ])
            ->add('destination', EntityType::class, [
                'class' => Trajet::class,
                'placeholder' => 'selectionner',
                'choice_label' => 'destination',
                'choice_value' => 'destination',
                'autocomplete' => true
            ])
            ->add('minDistance', IntegerType::class)
            ->add('maxDistance', IntegerType::class)
            ->add('minViews', IntegerType::class)
            ->add('maxViews', IntegerType::class)
            ->add('minDateCreation', DateType::class)
            ->add('maxDateCreation', DateType::class)
            ->add('filter', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}