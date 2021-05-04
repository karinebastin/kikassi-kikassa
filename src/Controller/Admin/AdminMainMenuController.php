<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminMainMenuController extends AbstractController
{
    #[Route('/admin/menu', name: 'admin-main-menu')]
    public function index(): Response
    {
        return $this->render('admin/admin_menus/main_menu.html.twig', [
            'controller_name' => 'AdminMainMenuController',
            'section' => 'section-main',
            'return_path' => 'admin-main-menu',
        ]);
    }

    #[Route('/admin', name: 'admin-main')]
    public function redirectToMenu(): Response
    {
        return $this->redirectToRoute('admin-main-menu');
    }
}