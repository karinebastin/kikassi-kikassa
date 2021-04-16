<?php

namespace App\Controller\Admin;

use App\Repository\LieuRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class lieuxListController extends AbstractController
{
    #[Route('/admin/lieux/list', name: 'admin_lieux_list')]
    public function index(LieuRepository $repo): Response
    {
        $lieux = $repo->findAll();
        return $this->render('admin/lieux_list/index.html.twig', [
            'controller_name' => 'LieusListController',
            'lieux' => $lieux,
            'section' => 'section-lieux',
            'return_path' => 'menu-lieu',
            'color' => 'lieux-color'
        ]);
    }
}