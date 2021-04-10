<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminEmpruntMenuController extends AbstractController
{
    #[Route('/admin/emprunt', name: 'menu-emprunt')]
    public function index(): Response
    {
        return $this->render('admin/admin_emprunt_menu/index.html.twig', [
            'controller_name' => 'AdminEmpruntMenuController',
            'color' => 'emprunt-color',
            'items' => [['text' => "VALIDER LES RÉSERVATIONS D'OBJETS", 'icon' => 'check' ], ['text' => "ENREGISTRER UN DÉPART D'OBJET", 'icon' => 'leave' ],['text' => "ENREGISTRER UN RETOUR D'OBJET", 'icon' => 'return' ], ['text' => 'CRÉER UN NOUVEL EMPRUNT', 'icon' => 'basket' ], ['text' => 'MODIFIER / SUPPRIMER UN EMPRUNT', 'icon' => 'pen' ], ['text' => 'AFFICHER LES EMPRUNTS', 'icon' => 'show' ] ]
        ]);
    }
}