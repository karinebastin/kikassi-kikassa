<?php

namespace App\Controller\Admin;

use App\Entity\Objet;
use PhpOffice\PhpSpreadSheet\v;

// Include PhpSpreadSheet required namespaces
use App\Repository\ObjetRepository;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Csv;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class CsvMakerController extends AbstractController
{
#[Route('/objetmin/details/objet/csv', name: 'admin_csv_objet')]

    public function index(KernelInterface $appKernel, ObjetRepository $repo)
    {
        $objets = $repo->findAll();
        $spreadSheet = new Spreadsheet();
        $date = date("d-m-Y H-i-s");
        $date2 = date("d-m-Y");
        
        $sheet = $spreadSheet->getActiveSheet();
  
        $titresColonnes = ['Id', 'Dénomination', 'Marque', 'Description',   "Valeur d'achat", "Coefficient d'usure", 'Pourcentage de calcul', 'Vitrine', 'Adherent', "Date d'ajout", "Catégorie", "Sous-categorie",  'Lieu de stockage', "Statut", "Observation", "Catalogue", "Date de sortie du stock"];

        $sheet->setCellValue('C1', 'La liste des objets au ' . $date2);
        $lettre = 'A';
        foreach ($titresColonnes as $titre) {
            $sheet  ->setCellValue($lettre.'3', $titre);
            $lettre++;
        }

 $lignes = 4;
   foreach ($objets as $objet) {
        $sheet
            ->setCellValue('A' . $lignes, $objet->getId())
            ->setCellValue('B' . $lignes, $objet->getDenomination())
            ->setCellValue('C' . $lignes, $objet->getMarque())
            ->setCellValue('D' . $lignes, $objet->getDescription())
            ->setCellValue('E' . $lignes, $objet->getValeurAchat())
            ->setCellValue('F' . $lignes, $objet->getCoefUsure())
            ->setCellValue('G' . $lignes, $objet->getPourcentCalcul() . '%')
            ->setCellValue('H' . $lignes, $objet->getVitrine() ? "Oui" : "Non")
            ->setCellValue('I' . $lignes, $objet->getAdherent() ? $objet->getAdherent()->getNomprenom() : "")
            ->setCellValue('J' . $lignes, date_format($objet->getDateCreation(),"d/m/Y"))
            ->setCellValue('K' . $lignes, $objet->getSousCategorie()->getCategorie()->getNomCategorie())
            ->setCellValue('L' . $lignes, $objet->getSousCategorie()->getNomSsCategorie())
            ->setCellValue('M' . $lignes, $objet->getLieu()->getNom())
            ->setCellValue('N' . $lignes, $objet->getStatut())
            ->setCellValue('O' . $lignes, $objet->getObservation())
            ->setCellValue('P' . $lignes, $objet->getCatalogue()->getNomCatalogue())
            ->setCellValue('Q' . $lignes, date_format($objet->getDateSortieStock(),"d/m/Y"));
            $lignes++;
        }

        $writer = new Csv($spreadSheet);
        
        $publicDirectory = $appKernel->getProjectDir() . '/public';
        $excelFilepath =  $publicDirectory . '/objets_CSV_' .$date. '.csv';
        
        $writer->save($excelFilepath);
        
        return new Response("Excel generated succesfully");
    }
}