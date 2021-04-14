<?php

namespace App\Controller\Admin;

use App\Repository\EmpruntRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class EmpruntsListController extends AbstractController
{
    #[Route('/admin/emprunts/list', name: 'admin_emprunts_list')]
    public function index(EmpruntRepository $repo): Response
    {
        $emprunts = $repo->findAll();


        return $this->render('admin/emprunts_list/index.html.twig', [
            'controller_name' => 'EmpruntsListController',
            'emprunts' => $emprunts,
            'section' => 'section-emprunts',
            'return_path' => 'menu-emprunt',
            'color' => 'emprunts-color'
        ]);
    }
}