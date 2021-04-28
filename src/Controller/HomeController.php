<?php

namespace App\Controller;

use App\Entity\Objet;
use App\Repository\CalendrierRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(): Response
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
    #[Route('/{slug}/detail', name: 'objetDetail')]
    public function detailsObjet(Objet $objet, CalendrierRepository $calendrier): Response
    {
        $events = $calendrier->findAll();
        // dd($events);
        $rdvs = [];
        foreach ($events as $event) {
            $rdvs[] = [
                'id' => $event->getId(),
                'start' => $event->getstart()->format('Y-m-d'),
                'end' => $event->getEnd()->format('Y-m-d'),
                'title' => $event->getTitle(),
                'description' => $event->getDescription(),
                'backgroundColor' => $event->getBackgroundColor(),
                'borderColor' => $event->getBorderColor(),
                'textColor' => $event->getTextColor(),
                'AllWeek' => $event->getAllWeek(),
            ];
        }
        $data = json_encode($rdvs);

        return $this->render('home/detailsObjet.html.twig', [
            'controller_name' => 'HomeController',
            'objet' => $objet,
            'data' => $data,
        ]);
    }
}
