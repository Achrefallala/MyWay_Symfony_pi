<?php
namespace App\Form;

use App\Entity\Guide;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\GreaterThan;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class GuideType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Le champ nom ne peut pas être vide.',
                    ]),
                    new Length([
                        'min' => 2,
                        'minMessage' => 'Le champ nom doit contenir au moins {{ limit }} caractères.',
                    ]),
                ],
            ])
            ->add('prenom', TextType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Le champ prénom ne peut pas être vide.',
                    ]),
                    new Length([
                        'min' => 2,
                        'minMessage' => 'Le champ prénom doit contenir au moins {{ limit }} caractères.',
                    ]),
                ],
            ])
            ->add('age', IntegerType::class, [
                'constraints' => [
                    new GreaterThan([
                        'value' => 17,
                        'message' => 'Vous devez être majeur(e).',
                    ]),
                ],
            ])
            ->add('langues', TextType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Le champ langues ne peut pas être vide.',
                    ]),
                ],
            ])
            ->add('experiences', TextType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Le champ expériences ne peut pas être vide.',
                    ]),
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Guide::class,
        ]);
    }
}
