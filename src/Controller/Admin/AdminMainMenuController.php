<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminMainMenuController extends AbstractController
{
    #[Route('/admin/menu', name: 'admin_main_menu')]
    public function index(): Response
    {
        return $this->render('admin/admin_menus/main_menu.html.twig', [
            'controller_name' => 'AdminMainMenuController',
            'section' => 'section-main',
            'return_path' => 'admin_main_menu',
        ]);
    }

    #[Route('/admin', name: 'admin_main')]
    public function redirectToMenu(): Response
    {
        return $this->redirectToRoute('admin_main_menu');
    }
}