<?php

namespace App\Controller\Admin;

use App\Entity\Adherent;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TelephoneField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class AdherentCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Adherent::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('Nom'),
            TextField::new('Prenom'),
            TextField::new('Adresse'),
            TextField::new('CP'),
            TextField::new('Ville'),
            EmailField::new('Email'),
            TelephoneField::new('Telephone'),
            DateField::new('Date_naissance'),
            TextField::new('Lieu_naissance'),
            TextField::new('Categorie_fourmi'),
            MoneyField::new('Montant_cotisation')->setCurrency('EUR'),
            TextField::new('Moyen_paiement'),
            DateField::new('Date_adhesion'),
            BooleanField::new('Compte_actif'),
            BooleanField::new('Admin'),
            TextField::new('Slug')

        ];
    }
}