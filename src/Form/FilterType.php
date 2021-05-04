<?php

namespace App\Form;

use App\Entity\Adherent;
use App\Entity\AdhesionBibliotheque;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('categorie_fourmi', EntityType::class, [
            // looks for choices from this entity
            'class' => AdhesionBibliotheque::class,
            'label' => false,
            'required' => false,
            // uses the User.username property as the visible option string
            'choice_label' => 'categorie_fourmi',
        
            // used to render a select box, check boxes or radios
            'multiple' => false,
            'expanded' => false
        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => AdhesionBibliotheque::class,
        ]);
    }
}