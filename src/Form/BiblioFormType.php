<?php

namespace App\Form;


use App\Entity\AdhesionBibliotheque;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class BiblioFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
             ->add('categorie_fourmi', ChoiceType::class, [
                
                'choices' => [
                'Verte' => 'verte',
                'Bleue' => 'bleue',
                'Dorée' => 'dorée',
                ],
                'expanded' => true, 
                'multiple' => false,])
            ->add('depot_permanent', ChoiceType::class, [
                'choices' => [
                'Montant du dépôt de garantie' => null,
                '30' => 30,
                '60' => 60,
                '90' => 90,
                '120' => 120,
                ]])
            ->add('fin_rc', DateType::class, [
                    'label' => '',
                    'widget' => 'single_text',
                    'attr' => ['placeholder' => 'Date de fin de la responsabilité civile, format : 10/05/1950'],
                    'input' => 'datetime',
                    'html5' => false,
                    'format' => 'dd/MM/yyyy',
                ])
            ->add('justif_identite', ChoiceType::class, [
                
                    'choices' => [
                    'Oui' => true,
                    'Non' => false,
                    ],
                    'expanded' => true, 
                    'multiple' => false,
                    ])
            ->add('justif_domicile', ChoiceType::class, [
                    'choices' => [
                    'Oui' => true,
                    'Non' => false,
                    ],
                    'expanded' => true, 
                    'multiple' => false
                    ])
                    ->add('save', SubmitType::class,['label' => 'Envoyer'])
            ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => AdhesionBibliotheque::class,
        ]);
    }
}