<?php

namespace App\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Trajet;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class FilterEtablissementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('type', ChoiceType::class, [
                'placeholder' => 'selectionner',
                'choices' => [
                    'Café' => 'café',
                    'Musée' => 'musée',
                    'Restaurant' => 'restaurant',
                    'Grand surface' => 'grand surface',
                    'Magasin' => 'magasin',
                    'Salle de sport' => 'salle de sport',
                    'Centre Médical' => 'centre médical',
                    'Pâtisserie' => 'pâtisserie',
                    'Boulangerie' => 'boulangerie',
                    'Kiosque' => 'kiosque',
                    'Lavage' => 'lavage',
                    'Librairie' => 'librairie',
                    'Cinéma' => 'cinéma',
                    'Théâtre' => 'théâtre',
                ],
            ])
            ->add('adresse', TextType::class)
            ->add('depart', EntityType::class, [
                  'class' => Trajet::class,
                  'placeholder' => 'selectionner',
                  'choice_label' => 'depart',
                  'choice_value' => 'depart',
                  'autocomplete' =>true
            ])
            ->add('destination', EntityType::class, [
                'class' => Trajet::class,
                'placeholder' => 'selectionner',
                'choice_label' => 'destination',
                'choice_value' => 'destination',
                'autocomplete' =>true
          ])
            ->add('minViews', IntegerType::class)
            ->add('maxViews', IntegerType::class)
            ->add('minDateCreation', DateType::Class)
            ->add('maxDateCreation', DateType::Class)
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