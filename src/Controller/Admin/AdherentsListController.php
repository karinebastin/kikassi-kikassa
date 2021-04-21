<?php

namespace App\Controller\Admin;

use App\Repository\AdherentRepository;
use App\Repository\AdhesionBibliothequeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdherentsListController extends AbstractController
{
    #[Route('/admin/adherents/list', name: 'admin_adherents_list')]
    public function index(AdherentRepository $repo): Response
    {
        $adherents = $repo->findAll();


        return $this->render('admin/lists/adherents_list.html.twig', [
            'controller_name' => 'AdherentsListController',
            'adherents' => $adherents,
            'section' => 'section-adherents',
            'return_path' => 'menu-adherent',
            'color' => 'adherents-color'
        ]);
    }

    #[Route('/admin/adherents/list/{item}', name: 'admin_adherents_list_sort')]
    public function sortData($item, AdherentRepository $repo): Response
    {
        $adherents = $repo->findBy(array(), array($item => 'asc'));

        return $this->render('admin/lists/adherents_list.html.twig', [
            'controller_name' => 'AdherentsListController',
            'adherents' => $adherents,
            'section' => 'section-adherents',
            'return_path' => 'menu-adherent',
            'color' => 'adherents-color'
        ]);
    }

}