<?php

namespace App\Form;

use App\Entity\Guide;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Doctrine\ORM\EntityManagerInterface;

class RatingType extends AbstractType
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class)
            ->add('note', IntegerType::class, [
                'label' => 'Note',
                'attr' => [
                    'min' => 1,
                    'max' => 5,
                    'step' => 1,
                    'readonly' => true,
                ],
            ])
            ->add('submit', SubmitType::class);

        $builder->get('note')->addEventListener(
            FormEvents::POST_SUBMIT,
            function (FormEvent $event) {
                $rating = $event->getData();
                $guide = $event->getForm()->getParent()->getData();

                $guide->addRating($rating);
                $this->entityManager->persist($guide);
                $this->entityManager->flush();
            }
        );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Guide::class,
        ]);
    }
}