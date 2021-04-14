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
            'section' => 'section-objets',
            'color' => 'objets-color',
            'return_path' => 'admin-main-menu',
            'items' => [['text' => "AJOUTER UN NOUVEL OBJET", 'icon' => 'new', 'link' => 'test'  ], ['text' => "MODIFIER UN OBJET", 'icon' => 'pen', 'link' => 'test'  ],['text' => "AJOUTER / MODIFIER UN CATALOGUE", 'icon' => 'catalog', 'link' => 'test'  ], ['text' => 'LES CATÉGORIES / SOUS-CATÉGORIES', 'icon' => 'categories', 'link' => 'test'  ], ['text' => 'AFFICHER LES OBJETS', 'icon' => 'show', 'link' => 'admin_objets_list'  ] ]
        ]);
    }
}