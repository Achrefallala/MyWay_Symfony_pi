<?php
namespace App\Form;

use App\Entity\Chauffeur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Component\Validator\Constraints\Length;
class ChauffeurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
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
            ->add('horaires', ChoiceType::class, [
                'choices' => [
                    '08:00 à 14:00' => '08:00 à 14:00',
                    '14:00 à 20:00' => '14:00 à 20:00',
                    '20:00 à 02:00' => '20:00 à 02:00',
                    '02:00 à 08:00' => '02:00 à 08:00'
                   
                ],
                'placeholder' => 'Choisir une heure',
            ])
            ->add('experiences', TextType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Le champ expériences ne peut pas être vide.',
                    ]),
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Chauffeur::class,
        ]);
    }

    private function generateHourChoices()
    {
        $choices = [];
        for ($i = 0; $i < 24; $i++) {
            $hour = str_pad($i, 2, '0', STR_PAD_LEFT);
            $choices[$hour] = $hour;
        }
        return $choices;
    }

    private function generateMinuteChoices()
    {
        $choices = [];
        for ($i = 0; $i < 60; $i++) {
            $minute = str_pad($i, 2, '0', STR_PAD_LEFT);
            $choices[$minute] = $minute;
        }
        return $choices;
    }
}
