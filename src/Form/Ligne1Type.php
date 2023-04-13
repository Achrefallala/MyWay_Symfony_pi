<?php

namespace App\Form;

use App\Entity\Ligne;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class Ligne1Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('trajet', null, [
                'empty_data' => '',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Le champ trajet ne peut pas être vide.',
                    ]),
                ],
            ])
            ->add('moyentp', null, [
                'empty_data' => '',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Le champ moyen de transport ne peut pas être vide.',
                    ]),
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Ligne::class,
        ]);
    }
}
