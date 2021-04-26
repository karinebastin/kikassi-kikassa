<?php

namespace App\Form;

use App\Entity\Adherent;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class AdhesionFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class, [
                'label' => '',
                'attr' => ['placeholder' => 'Nom de l\'adhérent'],
            ])
            ->add('prenom', TextType::class, [
                'label' => '',
                'attr' => ['placeholder' => 'Prénom de l\'adhérent'],
            ])
            ->add('adresse', TextType::class, [
                'label' => '',
                'attr' => ['placeholder' => 'Adresse : n° et nom de rue'],
            ])
            ->add('cp', TextType::class, [
                'label' => '',
                'attr' => ['placeholder' => 'Code Postal'],
            ])
            ->add('ville', TextType::class, [
                'label' => '',
                'attr' => ['placeholder' => 'Ville'],
            ])
            ->add('email', EmailType::class, [
                'label' => '',
                'attr' => ['placeholder' => 'Adresse email'],
                'required' => false
            ])
            ->add('telephone', TextType::class, [
                'label' => '',
                'attr' => ['placeholder' => 'N° de Téléphone'],
            ])
            ->add('date_naissance', DateType::class, [
                'label' => '',
                'widget' => 'single_text',
                'attr' => ['placeholder' => 'Date de naissance, format : 10/05/1950'],
                'input' => 'datetime',
                'html5' => false,
                'format' => 'dd/MM/yyyy',
                
            ])
            ->add('lieu_naissance', TextType::class, [
                'label' => '',
                'attr' => ['placeholder' => 'Lieu de naissance'],
            ])
            ->add('montant_cotisation', TextType::class, [
                'label' => '',
                'attr' => ['placeholder' => 'Montant de la cotisation en €'],
                'required' => false
            ])
            ->add('moyen_paiement', ChoiceType::class, [
                'choices' => [
                'moyen de paiement utilisé' => null,
                'Liquide' => "liquide",
                'Carte Bancaire' => 'cb',
                'Chèque' => "chèque",
                'Autre...' => "autre"
                ],
                'required' => false])
            ->add('etat_cotisation', ChoiceType::class, [
                'choices' => [
                'Etat du paiement de la cotisation' => null,
                'Payée' => "payée",
                'Due' => 'due',
                'Exonéré de cotisation' => "exonéré"
                ]])
            ->add('admin', ChoiceType::class, [
                'choices' => [
                'Accorder des droits d\'admin' => null,
                'Oui' => 1,
                'Non' => 0,
                ]
            ])
            ->add('saveAndContinue', SubmitType::class,[ 'label'=> '<i class="fas fa-arrow-right fa-3x"></i>', 'label_html' => true,'attr' => ['class' => 'border-0 bg-transparent p-0'] ])
            ->add('save', SubmitType::class,[ 'label'=> '<div class="btn-text p-1 px-2">Valider <br> l\'inscription</div>', 'label_html' => true, 'attr' => ['class' => 'envoi-btn font-raleway'] ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Adherent::class,
        ]);
    }
}