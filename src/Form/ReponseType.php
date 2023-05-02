<?php

namespace App\Form;

use App\Entity\Reclamation;
use App\Entity\Reponse;
use App\Repository\ReclamationRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReponseType extends AbstractType
{

    private $reclamationRepository;

    public function __construct(ReclamationRepository $reclamationRepository)
    {
        $this->reclamationRepository = $reclamationRepository;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('reponse')
            // ->add('message',  EntityType::class, [
            //     'class' => Reclamation::class,
            //     'choices' => $this->reclamationRepository->findAll(),
            //     'choice_label' => 'titre',
            //     'choice_value' => 'id',
            // ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reponse::class,
        ]);
    }
}
