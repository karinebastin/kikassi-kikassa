<?php

namespace App\Controller;

use App\Repository\AdherentRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TestController extends AbstractController
{
    #[Route('/test', name: 'test')]
    public function index(AdherentRepository $repo): Response
    {
        $adhe = $repo->findAll();
        $tableHeads = [];
        foreach ($adhe as $adh) {
            $tableHeads[] = [
                'Nom' => $adh->getNom(),
                'Prénom' => $adh->getPrenom(),
                'Téléphone' => $adh->getTelephone(),
                'Fourmi' => $adh->getAdhesionBibliotheque(),
            ];
        }
        dump($tableHeads);
        return $this->render('test/index.html.twig', [
            'controller_name' => 'TestController',
            'adh' => $adh,
            'tableHeads' => $tableHeads,
        ]);
    }
}

// [
//     'it1' => 'Nom',
//     'val1' => $adh->getNom(),
//     'it2' => 'Prénom',
//     'val2' => $adh->getPrenom(),
//     'it3' => 'Téléphone',
//     'val3' => $adh->getTelephone(),
//     'it4' => 'Fourmi',
//     'valA' =>
//         $adh->getAdhesionBibliotheque() != null
//             ? $adh->getAdhesionBibliotheque()->getCategorieFourmi()
//             : ' /',
// ];