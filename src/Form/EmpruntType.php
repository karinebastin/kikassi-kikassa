<?php

namespace App\Form;

use App\Entity\Emprunt;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

class EmpruntType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('date_debut', DateType::class, [
                'widget' => 'single_text',
                'placeholder' => ['Date de début au format 01/01/2000']
            ])
            ->add('date_fin', DateType::class, [
                'widget' => 'single_text',
                'placeholder' => ['Date de fin au format 01/01/2000']
            ])
            ->add('emprunt_regle', HiddenType::class, [
                'data' => 'false'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Emprunt::class,
        ]);
    }
}
