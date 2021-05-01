<?php

namespace App\Form;

use App\Entity\Objet;
use App\Entity\AdhesionBibliotheque;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class SearchFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class)
            ->add('search', SubmitType::class, [
                'label' => '<div class="btn-text p-1 px-2">Ok</div>',
                'label_html' => true,
                'attr' => ['class' => 'envoi-btn font-raleway'],
            ])
            ->add('send', SubmitType::class, [
                'label' => '<div class="btn-text p-1 px-2">Choisir</div>',
                'label_html' => true,
                'attr' => ['class' => 'envoi-btn font-raleway'],
            ]);
    }

    // public function configureOptions(OptionsResolver $resolver)
    // {
    //     $resolver->setDefaults([
    //         'data_class' => '',
    //     ]);
    // }
}