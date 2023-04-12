<?php

namespace App\Form;

use App\Entity\Etablissement;
use App\Entity\Trajet;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Choice;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\NotNull;

class EtablissementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class)
            ->add('type', ChoiceType::class, [
                'choices'  => [
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
            ->add('imageFile', FileType::class, [
                'mapped' => False,
                'required' => false,
                'constraints' => [
                    new File([                     
                        'mimeTypes' => [
                            'image/*',     
                        ],
                        'mimeTypesMessage' => 'Veuillez choisir un fichier image valide',
                    ]),

                ]
            ])
            ->add('telephone', IntegerType::class)
            ->add('email', EmailType::class)
            ->add('description')
            ->add('horaires', TextType::class)
            ->add('trajet', EntityType::class, [
                'class' => Trajet::class,
                'choice_label' => function ($trajet) {
                    return $trajet->getDepart().' --- '.$trajet->getDestination();
                },
                'multiple' => false,
                'expanded' => false,
            ])
            ->add('save', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Etablissement::class,
        ]);
    }
}
