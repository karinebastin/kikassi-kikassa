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
            'color' => 'emprunts-color',
            'section' => 'section-emprunts',
            'return_path' => 'admin-main-menu',
            'items' => [['text' => "VALIDER LES RÉSERVATIONS D'OBJETS", 'icon' => 'check', 'link' => 'test'  ], ['text' => "ENREGISTRER UN DÉPART D'OBJET", 'icon' => 'leave', 'link' => 'test'  ],['text' => "ENREGISTRER UN RETOUR D'OBJET", 'icon' => 'return', 'link' => 'test'  ], ['text' => 'CRÉER UN NOUVEL EMPRUNT', 'icon' => 'basket', 'link' => 'test'  ], ['text' => 'MODIFIER / SUPPRIMER UN EMPRUNT', 'icon' => 'pen', 'link' => 'test'  ], ['text' => 'AFFICHER LES EMPRUNTS', 'icon' => 'show', 'link' => 'test'  ] ]
        ]);
    }
}