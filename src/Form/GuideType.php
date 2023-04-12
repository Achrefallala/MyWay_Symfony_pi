<?php

namespace App\Form;

use App\Entity\Guide;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Range;

class GuideType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Le nom est obligatoire',
                    ]),
                    new Length([
                        'min' => 2,
                        'max' => 50,
                        'minMessage' => 'Le nom doit contenir au moins {{ limit }} caractères',
                        'maxMessage' => 'Le nom ne doit pas contenir plus de {{ limit }} caractères',
                    ]),
                ],
            ])
            ->add('prenom', TextType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Le prénom est obligatoire',
                    ]),
                    new Length([
                        'min' => 2,
                        'max' => 50,
                        'minMessage' => 'Le prénom doit contenir au moins {{ limit }} caractères',
                        'maxMessage' => 'Le prénom ne doit pas contenir plus de {{ limit }} caractères',
                    ]),
                ],
            ])
            ->add('age', IntegerType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'L\'âge est obligatoire',
                    ]),
                    new Range([
                        'min' => 0,
                        'max' => 99,
                        'invalidMessage' => 'L\'âge doit être compris entre {{ min }} et {{ max }}',
                    ]),
                ],
            ])
            ->add('langues', TextType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez sélectionner au moins une langue',
                    ]),
                    new Length([
                        'min' => 2,
                        'max' => 255,
                        'minMessage' => 'La langue doit contenir au moins {{ limit }} caractères',
                        'maxMessage' => 'La langue ne doit pas contenir plus de {{ limit }} caractères',
                    ]),
                ],
            ])
            ->add('experiences', TextType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'L\'expérience est obligatoire',
                    ]),
                    new Length([
                        'min' => 0,
                        'max' => 1000,
                        'minMessage' => 'L\'expérience doit contenir au moins {{ limit }} caractères',
                        'maxMessage' => 'L\'expérience ne doit pas contenir plus de {{ limit }} caractères',
                    ]),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Guide::class,
        ]);
    }
}
