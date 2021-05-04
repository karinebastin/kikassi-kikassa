<?php

namespace App\Controller;

use App\Entity\Objet;
use App\Repository\CalendrierRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(): Response
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
    #[Route('/{slug}/detail', name: 'objetDetail')]
    public function detailsObjet(Objet $objet, CalendrierRepository $calendrier): Response
    {
        return $this->render('home/detailsObjet.html.twig', [
            'controller_name' => 'HomeController',
            'objet' => $objet,
            // 'data' => $data,
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

    #[Route('/login', name: 'app_login')]
    public function loginUtilisateur(): Response
    {
        return $this->render('home/login.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
}
