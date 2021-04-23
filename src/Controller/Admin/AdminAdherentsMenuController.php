<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminAdherentsMenuController extends AbstractController
{
    #[Route('/admin/adherents', name: 'menu-adherent')]
    public function index(): Response
    {
        return $this->render('admin/admin_menus/adherents_menu.html.twig', [
            'controller_name' => 'AdminAdherentsMenuController',
            'return_path' => 'admin-main-menu',
            'section' => 'section-adherents',
            'color' => 'adherents-color',
            'items' => [['text' => 'INSCRIRE UN NOUVEL ADHÉRENT', 'icon' => 'plus', 'link' => 'admin_adherents_new' ], ['text' => 'CHANGER STATUT FOURMI', 'icon' => 'ant', 'link' => 'test' ],['text' => 'MODIFIER / RÉINSCRIRE UN ADHÉRENT', 'icon' => 'pen', 'link' => 'test' ], ['text' => 'PASSER UN ADHÉRENT EN ADMIN', 'icon' => 'admin', 'link' => 'test' ], ['text' => 'AFFICHER LES ADHÉRENTS', 'icon' => 'show', 'link' => 'admin_adherents_list' ] ]
        ]);
    }
}