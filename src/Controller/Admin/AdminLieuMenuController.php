<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminLieuMenuController extends AbstractController
{
    #[Route('/admin/lieu', name: 'menu-lieu')]
    public function index(): Response
    {
        return $this->render('admin/admin_lieu_menu/index.html.twig', [
            'controller_name' => 'AdminLieuMenuController',
            'color' => 'lieu-color',
            'items' => [ ['text' => 'AJOUTER UN NOUVEAU LIEU DE STOCKAGE', 'icon' => 'shop' ], ['text' => "AFFICHER / MODIFIER LES LIEUX DE STOCKAGE D'OBJETS", 'icon' => 'pen' ]]
        ]);
    }
}