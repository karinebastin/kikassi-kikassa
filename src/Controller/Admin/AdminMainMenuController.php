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
        return $this->render('admin/admin_main_menu/index.html.twig', [
            'controller_name' => 'AdminMainMenuController',
        ]);
    }
}