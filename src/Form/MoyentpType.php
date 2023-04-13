<?php

namespace App\Form;

use App\Entity\Moyentp;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class MoyentpType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('matricule')
          
            ->add('type', ChoiceType::class, [
                'placeholder' => 'choisir un type',
                'required' => true,
                'multiple' => false,
                'expanded' => false,
                'choices'  => [
                  'Metro' => 'METRO',
                  'Train' => 'TRAIN',
                  'Bus' => 'BUS',
                  
                ],
            ])
            ->add('nbreplace')
            ->add('prix_ticket')
            ->add('horaire')
            ->add('nom')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Moyentp::class,
        ]);
    }
}
