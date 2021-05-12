<?php

namespace App\Form;

use App\Entity\Adherent;
use App\Form\BiblioFormType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class AdhesionFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class, [
                'label' => 'Nom',
                'attr' => ['placeholder' => 'Nom de l\'adhérent'],
            ])
            ->add('prenom', TextType::class, [
                'label' => 'Prénom',
                'attr' => ['placeholder' => 'Prénom de l\'adhérent'],
            ])
            ->add('adresse', TextType::class, [
                'label' => 'Adresse',
                'attr' => ['placeholder' => 'Adresse : n° et nom de rue'],
            ])
            ->add('cp', TextType::class, [
                'label' => 'Code Postal',
                'attr' => ['placeholder' => 'Code Postal'],
            ])
            ->add('ville', TextType::class, [
                'label' => 'Ville',
                'attr' => ['placeholder' => 'Ville'],
            ])
            ->add('email', EmailType::class, [
                'label' => 'Adresse email',
                'attr' => ['placeholder' => 'Adresse email'],
                'required' => false,
            ])
            ->add('telephone', TextType::class, [
                'label' => 'N° de Téléphone',
                'attr' => ['placeholder' => 'N° de Téléphone'],
            ])
            ->add('date_naissance', DateType::class, [
                'label' => 'Date de naissance',
                'widget' => 'single_text',
                'attr' => [
                    'placeholder' => 'Date de naissance, format : 10/05/1950',
                ],
                'input' => 'datetime',
                'html5' => false,
                'format' => 'dd/MM/yyyy',
            ])
            ->add('lieu_naissance', TextType::class, [
                'label' => 'Lieu de naissance',
                'attr' => ['placeholder' => 'Lieu de naissance'],
            ])
            ->add('montant_cotisation', TextType::class, [
                'label' => 'Montant de la cotisation',
                'attr' => ['placeholder' => 'Montant de la cotisation en €'],
                'required' => false,
            ])
            ->add('moyen_paiement', ChoiceType::class, [
                'label' => 'Moyen de paiement utilisé',
                'placeholder' => 'moyen de paiement utilisé',
                'choices' => [
                    'Liquide' => 'liquide',
                    'Carte Bancaire' => 'cb',
                    'Chèque' => 'chèque',
                    'Autre...' => 'autre',
                ],
                'required' => false,
            ])
            ->add('etat_cotisation', ChoiceType::class, [
                'label' => 'Etat du paiement de la cotisation',
                'placeholder' => 'Etat du paiement de la cotisation',
                'choices' => [
                    'Payée' => 'payée',
                    'Due' => 'due',
                    'Exonéré de cotisation' => 'exonéré',
                ],
            ])
            ->add('saveAndContinue', SubmitType::class, [
                'label' => '<i class="fas fa-arrow-right fa-3x"></i>',
                'label_html' => true,
                'attr' => ['class' => 'border-0 bg-transparent p-0'],
            ])
            ->add('save', SubmitType::class, [
                'label' =>
                    '<div class="btn-text p-1 px-2">Valider <br> l\'inscription</div>',
                'label_html' => true,
                'attr' => ['class' => 'envoi-btn font-raleway'],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Adherent::class,
            'csrf_protection' => false,
        ]);
    }
}
