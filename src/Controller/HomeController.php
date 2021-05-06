<?php

namespace App\Controller;

use App\Entity\Objet;
use App\Repository\EmpruntRepository;
use App\Repository\ObjetRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(): Response
    {
        return $this->render('home/catalogue.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    #[Route('/{slug}/detail', name: 'objetDetail', methods: ['GET', 'POST'])]
    public function detailsObjet(Objet $objet, EmpruntRepository $emprunt): Response

    {
        return $this->render('home/detailsObjet.html.twig', [
            'controller_name' => 'HomeController',
            'objet' => $objet,
            'emprunt' => $emprunt,

        ]);
    }

    #[Route('/panier', name: 'panier')]
    public function panierIndex(): Response
    {
        return $this->render('home/panier.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    #[Route('/historique_panier', name: 'historiquePanier')]
    public function historiquePanierIndex(): Response
    {
        return $this->render('home/historiquePanier.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    // #[Route('/catalogue', name: 'catalogue')]
    // public function catalogue(): Response
    // {
    //     return $this->render('home/catalogue.html.twig', [
    //         'controller_name' => 'CatalogueController',
    //     ]);
    // }
}
