<?php

namespace App\Classes;

use App\Entity\Objet;
use App\Repository\ObjetRepository;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Csv;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpKernel\KernelInterface;


class CsvMaker
{
    private $appKernel;
    private $date;
    private $date2;

    public function __construct(KernelInterface $appKernel) {
        $this->appKernel = $appKernel;
        $this->date = date("d-m-Y H-i-s");
        $this->date2 = date("d-m-Y");
    }

    public function buildCsv($titresColonnes, $tabItems, $itemName)
    {
        $spreadSheet = new Spreadsheet;
        $sheet = $spreadSheet->getActiveSheet();
  
        $sheet->setCellValue('C1', 'La liste des '. $itemName . ' au ' . $this->date2);
        $lettre = 'A';
        foreach ($titresColonnes as $titre) {
            $sheet  ->setCellValue($lettre.'3', $titre);
            $lettre++;
        }
       
$col = "A";
$row = 4;
    foreach($tabItems as $value){
        $col = 'A';
        foreach($value as $val) {
            $sheet->setCellValue($col . $row, $val);
      $col++;
        }
          $row++;   
}
        $writer = new Csv($spreadSheet);
        
        $publicDirectory = $this->appKernel->getProjectDir() . '/public';
        $excelFilepath =  $publicDirectory . '/' . $itemName . '_CSV_' .$this->date. '.csv';
        
        $writer->save($excelFilepath);
        
        // return new Response("Excel generated succesfully");
    }
}