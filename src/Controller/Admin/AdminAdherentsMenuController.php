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
        ]);
    }
}