<?php

namespace App\Controller\Admin;

use App\Repository\AdherentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdherentsListController extends AbstractController
{
    #[Route('/admin/adherents/list', name: 'admin_adherents_list')]
    public function index(AdherentRepository $repo): Response
    {
        $adherents = $repo->findAll();


        return $this->render('admin/adherents_list/index.html.twig', [
            'controller_name' => 'AdherentsListController',
            'adherents' => $adherents,
            'section' => 'section-adherent',
            'return_path' => 'menu-adherent',
            'color' => 'adherent-color'
        ]);
    }
}