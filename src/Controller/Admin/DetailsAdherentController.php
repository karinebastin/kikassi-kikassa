<?php

namespace App\Controller\Admin;

use App\Repository\AdherentRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DetailsAdherentController extends AbstractController
{
    #[Route('/admin/details/adherent/{slug}', name: 'admin_details_adherent')]
    public function index(
        $slug,
        AdherentRepository $adherentRepository
    ): Response {
        $adherent = $adherentRepository->findOneBySlug($slug);

        return $this->render('admin/pages_details/details_adherent.html.twig', [
            'controller_name' => 'DetailsAdherentController',
            'adherent' => $adherent,
            'return_path' => 'menu-adherent',
            'section' => 'section-adherents',
            'color' => 'adherents-color',
        ]);
    }
}
