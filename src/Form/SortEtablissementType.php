<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class SortEtablissementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('trierPar', ChoiceType::class, [
            'placeholder' => 'selectionner',
            'choices' => [
                'Nom' => 'nom',
                'Nombre de vues' => 'views',
                'Date de création' => 'dateCreation',
            ],
            'expanded' => true
        ])
        ->add('type', ChoiceType::class, [
            'choices' => [
                'Croissant' => 'ASC',
                'decroissant' => 'DESC'
            ],
            'expanded' => true
        ])
        ->add('trier', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
