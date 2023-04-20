<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use App\Entity\Trajet;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;

use Symfony\Component\Validator\Constraints\NotNull;

class SearchTrajetByDepartAndDestinationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('trajet', EntityType::class, [  
                'constraints' => [
                    new NotNull([
                        'message' => 'Veuillez choisir un trajet'
                    ]),
                ],
                'class' => Trajet::class,
                'placeholder' => 'Trajet',
                'choice_label' => function ($trajet) {
                    return $trajet->getDepart().' --- '.$trajet->getDestination();
                },
                'autocomplete' => true,
                'tom_select_options' => [
                    'maxOptions' => 3,
                    'openOnFocus' => false
                ]
                
            ])
            ->add('search', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
