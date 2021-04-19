<?php

namespace App\Controller\Admin;

use App\Entity\Photo;
use App\Repository\ObjetRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ObjetsListController extends AbstractController
{
    #[Route('/admin/objets/list', name: 'admin_objets_list')]
    public function index(ObjetRepository $repo): Response
    {
        $objets = $repo->findAll();
        
        return $this->render('admin/lists/objets_list.html.twig', [
            'controller_name' => 'ObjetsListController',
            'objets' => $objets,
            'section' => 'section-objets',
            'return_path' => 'menu-objet',
            'color' => 'objets-color'
        ]);
    }
    #[Route('/admin/details/objet/{slug}', name: 'admin_details_objet')]
    public function showDetails( $slug, ObjetRepository $objetRepository): Response
    {
        $objet = $objetRepository->findOneBySlug($slug);

        
        return $this->render('admin/pages_details/details_objet.html.twig', [
            'controller_name' => 'DetailsAdherentController',
            'objet' => $objet,
            'return_path' => 'menu-objet',
            'section' => 'section-objets',
            'color' => 'objets-color'
        ]);
    }


}