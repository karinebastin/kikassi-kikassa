<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminLieuMenuController extends AbstractController
{
    #[Route('/admin/lieux', name: 'menu-lieu')]
    public function index(): Response
    {
        return $this->render('admin/admin_menus/lieux_menu.html.twig', [
            'controller_name' => 'AdminLieuMenuController',
            'section' => 'section-lieux',
            'color' => 'lieux-color',
            'return_path' => 'admin-main-menu',
            'items' => [ ['text' => 'AJOUTER UN NOUVEAU LIEU DE STOCKAGE', 'icon' => 'shop', 'link' => 'test'  ], ['text' => "AFFICHER / MODIFIER LES LIEUX DE STOCKAGE D'OBJETS", 'icon' => 'pen', 'link' => 'admin_lieux_list'  ]]
        ]);
    }
}