<?php

namespace App\Controller\Admin;

use App\Classes\CsvMaker;
use App\Repository\AdherentRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CsvAdherentsController extends AbstractController
{
    #[Route('/amin/details/adherent/csv', name: 'admin_csv_adherent')]

    public function index(CsvMaker $csv, AdherentRepository $repo): Response
    {
        $adherents = $repo->findAll();
        $titresColonnes = [
            'Id',
            'Nom',
            'Prénom',
            'Adresse',
            'CP',
            'Ville',
            'Email',
            'Téléphone',
            'Date de naissance',
            'Lieu de naissance',
            'Montant cotisation',
            'Moyen de paiement',
            'Etat cotisation',
            "Date d'adhésion",
            'Est admin',
            'Est inscrit à la bibliothèque',
            'Catégorie Fourmi',
            'Montant du dépôt permanent',
            'Date de fin de responsabilité civile',
            "Justificatif d'identité",
            'Justificatif de domicile',
        ];
        $itemsName = 'adhérents';
        $tabAdherents = [];
        foreach ($adherents as $adherent) {
            $tabAdherents[] = [
                $adherent->getId(),
                $adherent->getNom(),
                $adherent->getPrenom(),
                $adherent->getAdresse(),
                $adherent->getCp(),
                $adherent->getVille(),
                $adherent->getEmail(),
                $adherent->getTelephone(),
                date_format($adherent->getDateNaissance(), 'd/m/Y'),
                $adherent->getLieuNaissance(),
                $adherent->getMontantCotisation() . '€',
                $adherent->getMoyenPaiement(),
                $adherent->getEtatCotisation(),
                date_format($adherent->getDateAdhesion(), 'd/m/Y'),
                $adherent->getAdhesionBibliotheque() ? 'Oui' : 'Non',
                $adherent->getAdhesionBibliotheque()
                    ? $adherent->getAdhesionBibliotheque()->getCategorieFourmi()
                    : ' /',
                $adherent->getAdhesionBibliotheque()
                    ? $adherent
                            ->getAdhesionBibliotheque()
                            ->getDepotPermanent() . '€'
                    : ' /',
                $adherent->getAdhesionBibliotheque() &&
                $adherent->getAdhesionBibliotheque()->getFinRc()
                    ? date_format(
                        $adherent->getAdhesionBibliotheque()->getFinRc(),
                        'd/m/Y'
                    )
                    : ' /',
                $adherent->getAdhesionBibliotheque() &&
                in_array($adherent->getAdhesionBibliotheque()->getRoles(), [
                    'ROLE_ADMIN',
                ])
                    ? 'Oui'
                    : 'Non',
                $adherent->getAdhesionBibliotheque() &&
                $adherent->getAdhesionBibliotheque()->getJustifDomicile()
                    ? 'Oui'
                    : 'Non',
                $adherent->getAdhesionBibliotheque() &&
                $adherent->getAdhesionBibliotheque()->getJustifIdentite()
                    ? 'Oui'
                    : 'Non',
            ];
        }

        $csv->buildCsv($titresColonnes, $tabAdherents, $itemsName);

        return $this->render('admin/csv_maker.html.twig', [
            'controller_name' => 'CsvAdherentsController',
            'name' => $itemsName,
            'return_path' => 'menu-adherent',
            'section' => 'section-adherents',
            'color' => 'adherents-color',
        ]);
    }
}