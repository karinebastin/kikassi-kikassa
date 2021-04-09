<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminAdherentsMenuController extends AbstractController
{
    #[Route('/admin/adherents', name: 'menu-adherents')]
    public function index(): Response
    {
        return $this->render('admin/admin_adherents_menu/index.html.twig', [
            'controller_name' => 'AdminAdherentsMenuController',
            'color' => 'adherent-color',
            'items' => [['text' => 'INSCRIRE UN NOUVEL ADHÉRENT', 'icon' => 'plus' ], ['text' => 'CHANGER STATUT FOURMI', 'icon' => 'ant' ],['text' => 'MODIFIER / RÉINSCRIRE UN ADHÉRENT', 'icon' => 'pen' ], ['text' => 'PASSER UN ADHÉRENT EN ADMIN', 'icon' => 'admin' ], ['text' => 'AFFICHER LES ADHÉRENTS', 'icon' => 'show' ] ]
        ]);
    }
}