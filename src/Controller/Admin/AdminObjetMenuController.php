<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminObjetMenuController extends AbstractController
{
    #[Route('/admin/objet', name: 'menu-objet')]
    public function index(): Response
    {
        return $this->render('admin/admin_objet_menu/index.html.twig', [
            'controller_name' => 'AdminObjetMenuController',
            'color' => 'objet-color',
            'items' => [['text' => "AJOUTER UN NOUVEL OBJET", 'icon' => 'new' ], ['text' => "MODIFIER UN OBJET", 'icon' => 'pen' ],['text' => "AJOUTER / MODIFIER UN CATALOGUE", 'icon' => 'catalog' ], ['text' => 'LES CATÉGORIES / SOUS-CATÉGORIES', 'icon' => 'categories' ], ['text' => 'AFFICHER LES OBJETS', 'icon' => 'show' ] ]
        ]);
    }
}