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
        $route = "down";
        dump($adherents);


        return $this->render('admin/lists/adherents_list.html.twig', [
            'controller_name' => 'AdherentsListController',
            'adherents' => $adherents,
            'route' => $route,
            'section' => 'section-adherents',
            'return_path' => 'menu-adherent',
            'color' => 'adherents-color'
        ]);
    }


    #[Route('/admin/adherents/list/{adh}/{order}', name: 'admin_adherents_list_sort')]
    public function sortDataD($adh, $order,  AdherentRepository $repo): Response
    {
        
        $biblio = ["fin_rc", "depot_permanent", "categorie_fourmi"];
        if(in_array($adh, $biblio) ){
            if($order == "up") {
                $adherents = $repo->orderByBiblioField($adh, "DESC"); 
                $route = "down";
            } else {
               $adherents = $repo->orderByBiblioField($adh, "ASC"); 
               $route = "up";
            }
        } else {
            if($order == "up") {
            $adherents = $repo->findBy(array(), array($adh => "DESC"));
            $route = "down";
            }
            else {
                $adherents = $repo->findBy(array(), array($adh => "ASC"));
                $route = "up";
            }
        }

        return $this->render('admin/lists/adherents_list.html.twig', [
            'controller_name' => 'AdherentsListController',
            'adherents' => $adherents,
            'route' => $route,
            'section' => 'section-adherents',
            'return_path' => 'menu-adherent',
            'color' => 'adherents-color'
        ]);
    }
}