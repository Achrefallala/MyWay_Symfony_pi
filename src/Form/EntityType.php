<?php
namespace App\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType as SymfonyEntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EntityType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'class' => null,
            'choice_label' => 'name',
            'placeholder' => 'Sélectionner',
            'required' => true,
            'label' => false,
        ]);
    }

    public function getParent()
    {
        return SymfonyEntityType::class;
    }
}