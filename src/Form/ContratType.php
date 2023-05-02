<?php

namespace App\Form;

use App\Entity\Contrat;
use App\Entity\Location;
use App\Repository\LocationRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class ContratType extends AbstractType
{

    private $locationRepository;

    public function __construct(LocationRepository $locationRepository)
    {
        $this->locationRepository = $locationRepository;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('prix', null, [
                "required" => false
            ])
            ->add('dateDebut', DateType::class, [
                'data' => new \DateTime(), // set default value to today's date
            ])
            ->add('dateFin', DateType::class, [
                'data' => new \DateTime(), // set default value to today's date
            ])
            ->add('location', EntityType::class,  [
                'class' => Location::class,
                'choices' => $this->locationRepository->findAll(),
                'choice_label' => 'nom',
                'choice_value' => 'id',
                'placeholder' => 'select location'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Contrat::class,
        ]);
    }
}
