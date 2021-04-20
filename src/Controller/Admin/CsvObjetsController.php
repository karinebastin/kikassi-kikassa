<?php

namespace App\Controller\Admin;

use App\Classes\CsvMaker;
use App\Repository\ObjetRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;



class CsvObjetsController extends AbstractController
{
#[Route('/amin/details/objet/csv', name: 'admin_csv_objet')]

    public function index(CsvMaker $csv, ObjetRepository $repo): Response
    {
        $objets = $repo->findAll();
        $titresColonnes = ['Id', 'Dénomination', 'Marque', 'Description',   "Valeur d'achat", "Coefficient d'usure", 'Pourcentage de calcul', 'Vitrine', 'Adhérent', "Date d'ajout", "Catégorie", "Sous-catégorie",  'Lieu de stockage', "Statut", "Observation", "Catalogue", "Date de sortie du stock"];
        $itemsName = 'objets';
        $tabObjets = [];
              foreach ($objets as $objet) {
                  $tabObjets[] = [
                      $objet->getId(),  $objet->getDenomination(), $objet->getMarque(), $objet->getDescription(), $objet->getValeurAchat(), $objet->getCoefUsure(), $objet->getPourcentCalcul() . '%',  $objet->getVitrine() ? "Oui" : "Non", $objet->getAdherent() ? $objet->getAdherent()->getNomprenom() : "", date_format($objet->getDateCreation(),"d/m/Y"), $objet->getSousCategorie()->getCategorie()->getNomCategorie(), $objet->getSousCategorie()->getNomSsCategorie(), $objet->getLieu()->getNom(), $objet->getStatut(), $objet->getObservation(), $objet->getCatalogue()->getNomCatalogue(), $objet->getDateSortieStock() ?date_format($objet->getDateSortieStock(),"d/m/Y") : ""
                   ];
               }

               $csv->buildCsv($titresColonnes, $tabObjets, $itemsName);
           
       
    return $this->render('admin/csv_maker.html.twig', [
        'controller_name' => 'CsvObjetsController',
        'name' => $itemsName,
        'return_path' => 'menu-objet',
        'section' => 'section-objets',
        'color' => 'objets-color'
    ]);
    }
}