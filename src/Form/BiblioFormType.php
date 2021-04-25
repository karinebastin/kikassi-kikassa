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
                'Catégorie Fourmi' => "",
                'Verte' => 'verte',
                'Bleue' => 'bleue',
                'Dorée' => 'dorée'
                ]])
            ->add('depot_permanent', ChoiceType::class, [
                'choices' => [
                'Montant du dépôt de garantie' => "",
                '30' => 30,
                '60' => 60,
                '90' => 90,
                '120' => 120
                ]])
            ->add('fin_rc', DateType::class, [
                    'widget' => 'single_text',
                    'attr' => ['placeholder' => 'Date de fin de la responsabilité civile (si donnée), format : 10/05/1950'],
                    'input' => 'datetime',
                    'html5' => false,
                    'format' => 'dd/MM/yyyy',
                    'required' => false
                ])
            ->add('justif_identite', ChoiceType::class, [
                    'choices' => [
                    'Justificatif d\'identité' => "",
                    'Oui' => true,
                    'Non' => false
                    ]
                    ])
            ->add('justif_domicile', ChoiceType::class, [
                    'choices' => [
                    'Justificatif de domicile' => "",
                    'Oui' => true,
                    'Non' => false
                    ]
                    ])
                    ->add('save', SubmitType::class,['label' => '<div class="btn-text px-2">Valider l\'inscription <br> à la Bibliothèque</div>', 'label_html' => true, 'attr' => ['class' => 'envoi-btn font-raleway'] ])
            ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => AdhesionBibliotheque::class,
        ]);
    }
}