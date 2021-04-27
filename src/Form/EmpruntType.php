<?php

namespace App\Form;

use App\Entity\Emprunt;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EmpruntType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('date_reservation')
            ->add('date_debut')
            ->add('date_fin')
            ->add('remarque')
            ->add('date_retour_objet')
            ->add('depot_rajoute')
            ->add('penalites')
            ->add('prix_emprunt')
            ->add('slug')
            ->add('statut')
            ->add('emprunt_regle')
            ->add('objet')
            ->add('adherent')
            ->add('super_admin')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Emprunt::class,
        ]);
    }
}
