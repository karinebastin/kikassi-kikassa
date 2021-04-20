<?php

namespace App\Controller\Admin;

use App\Classes\CsvMaker;
use App\Repository\EmpruntRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;



class CsvEmpruntsController extends AbstractController
{
#[Route('/amin/details/emprunt/csv', name: 'admin_csv_emprunt')]

    public function index(CsvMaker $csv, EmpruntRepository $repo): Response
    {
        $emprunts = $repo->findAll();
        $titresColonnes = ['Id', 'Nom adhérent', 'Prénom adhérent', 'Nom super Admin', 'Prénom super Admin',  'Objet emprunté', 'Remarque',  'Date de réservation',   "Statut de l'emprunt", "Date de début", 'Date de fin', "Date de retour de l'objet", 'Montant de dépôt occasionnel', "Prix de l'emprunt", "Emprunt payé", "Pénalités"];
        $itemsName = 'emprunts';
        $tabEmprunts = [];
              foreach ($emprunts as $emprunt) {
                  $tabEmprunts[] = [
                      $emprunt->getId(), $emprunt->getAdherent() ? $emprunt->getAdherent()->getNom() : " /", $emprunt->getAdherent() ? $emprunt->getAdherent()->getPrenom() : " /", $emprunt->getSuperAdmin() ? $emprunt->getSuperAdmin()->getNom() : " /",  $emprunt->getSuperAdmin() ? $emprunt->getSuperAdmin()->getPrenom() : " /", 
                      $emprunt->getObjet()->getDenomination(), 
                      $emprunt->getRemarque() ? $emprunt->getRemarque() : "",
                      date_format($emprunt->getDateReservation(),"d/m/Y"),
                       $emprunt->getStatut(), date_format($emprunt->getDateDebut(),"d/m/Y"),  date_format($emprunt->getDateFin(),"d/m/Y"), $emprunt->getDateRetourObjet() ? date_format($emprunt->getDateRetourObjet(),"d/m/Y") : "", 
                       $emprunt->getDepotRajoute(),  $emprunt->getPrixEmprunt(), $emprunt->getEmpruntRegle(), $emprunt->getPenalites() ? $emprunt->getPenalites() : ""
                   ];
               }

               $csv->buildCsv($titresColonnes, $tabEmprunts, $itemsName);
           
       
    return $this->render('admin/csv_maker.html.twig', [
        'controller_name' => 'CsvEmpruntsController',
        'name' => $itemsName,
        'return_path' => 'menu-emprunt',
        'section' => 'section-emprunts',
        'color' => 'emprunts-color'
    ]);
    }
}