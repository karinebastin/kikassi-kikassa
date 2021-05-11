<?php

namespace App\Controller;

use App\Entity\Objet;
use App\Entity\Emprunt;
use App\Form\EmpruntType;
use App\Entity\SuperAdmin;
use App\Repository\EmpruntRepository;
use App\Repository\AdherentRepository;
use App\Repository\ObjetRepository;
use App\Repository\SuperAdminRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/emprunt')]
class EmpruntController extends AbstractController
{
    #[Route('/', name: 'emprunt_index', methods: ['GET'])]
    public function index(EmpruntRepository $empruntRepository): Response
    {
        return $this->render('emprunt/index.html.twig', [
            'emprunts' => $empruntRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'emprunt_new', methods: ['GET', 'POST'])]
    public function new(Request $request, AdherentRepository $adherentRepository, SuperAdminRepository $superAdminRepository, ObjetRepository $objetRepository): Response
    {
        $emprunt = new Emprunt();
        $form = $this->createForm(EmpruntType::class, $emprunt);
        $form->handleRequest($request);

        // // Je récupère l'adhérent et je vérifie si c'est un adhérent ou super-admin
        $adherent = $adherentRepository->findOneById(
            $request->request->get('adherent')
        );
        $admin = $superAdminRepository->findOneById(
            $request->request->get('adherent')
        );
        $adherent
            ? $emprunt->setAdherent($adherent)
            : $emprunt->setSuperAdmin($admin);

        //Je récupère l'objet
        $objet = $objetRepository->findOneById($request->request->get('objet'));
        dump($objet);

        if ($form->isSubmitted() && $form->isValid()) {

            //     if ($objet) {
            //        if ($objet->getStatut() == 'Disponible') {
            //             // j'envoie en bdd l'objet
            //             $emprunt->setObjet($objet);
            //             // Je set la date de réservation uniquement si l'emprunt ne débute pas le jour même, et je la met à aujourd'hui
            //             $now = new \DateTime();
            //             if ($emprunt->getDateDebut() > $now) {
            //                 $emprunt->setDateReservation($now);
            //             }
            //             if ($emprunt->getDateFin() < $emprunt->getDateDebut()) {
            //                 $this->addFlash(
            //                     'danger',
            //                     "La date de fin d'emprunt ne peut pas être avant la date de début"
            //                 );
            //             }

            //             // calcul du prix de l'emprunt :
            //             $obj = $emprunt->getObjet();
            //             $days = $emprunt
            //                 ->getDateDebut()
            //                 ->diff($emprunt->getDateFin())->days;
            //             $prix =
            //                 (((($obj->getValeurAchat() *
            //                     $obj->getPourcentCalcul()) /
            //                     100) *
            //                     $obj->getCoefUsure()) /
            //                     5) *
            //                 $days;
            //             $emprunt->setPrixEmprunt($prix);

            //             // calcul du montant de dépôt de garantie à rajouter au dépôt permanent :
            //             $finrc = $adherent
            //                 ->getAdhesionBibliotheque()
            //                 ->getFinRc();
            //             $depot_perm = $adherent
            //                 ->getAdhesionBibliotheque()
            //                 ->getDepotPermanent();

            //             if ($adherent) {
            //                 if ($finrc > $now) {
            //                     $depot_rajoute =
            //                         ($obj->getValeurAchat() *
            //                             $obj->getCoefUsure()) /
            //                         5 /
            //                         3 -
            //                         $depot_perm;
            //                     dump('rc valide');
            //                 } else {
            //                     $depot_rajoute =
            //                         ($obj->getValeurAchat() *
            //                             $obj->getCoefUsure()) /
            //                         5 -
            //                         $depot_perm;
            //                     dump('pas rc ou rc perimee');
            //                 }
            //             } else {
            //                 $depot_rajoute = 0;
            //                 dump('est admin');
            //             }

            //             $emprunt->setDepotRajoute(
            //                 $depot_rajoute < 0 ? 0 : $depot_rajoute
            //             );

            //             // le statut de l'emprunt est mis "en attente de validation"
            //             $emprunt->setStatut("en attente de validation");

            //             dump($emprunt);
            //             $entityManager = $this->getDoctrine()->getManager();
            //             $entityManager->persist($emprunt);
            //             $entityManager->flush();

            //             return $this->redirectToRoute('home');
            //         }
            //     }
        }
        dump($emprunt);

        return $this->render('emprunt/new.html.twig', [
            'emprunt' => $emprunt,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'emprunt_show', methods: ['GET'])]
    public function show(Emprunt $emprunt): Response
    {
        return $this->render('emprunt/show.html.twig', [
            'emprunt' => $emprunt,
        ]);
    }

    // #[Route('/{id}/edit', name: 'emprunt_edit', methods: ['GET', 'POST'])]
    // public function edit(Request $request, Emprunt $emprunt): Response
    // {
    //     $form = $this->createForm(EmpruntType::class, $emprunt);
    //     $form->handleRequest($request);

    //     if ($form->isSubmitted() && $form->isValid()) {
    //         $this->getDoctrine()->getManager()->flush();

    //         return $this->redirectToRoute('emprunt_index');
    //     }

    //     return $this->render('emprunt/edit.html.twig', [
    //         'emprunt' => $emprunt,
    //         'form' => $form->createView(),
    //     ]);
    // }

    //     #[Route('/{id}', name: 'emprunt_delete', methods: ['POST'])]
    //     public function delete(Request $request, Emprunt $emprunt): Response
    //     {
    //         if ($this->isCsrfTokenValid('delete' . $emprunt->getId(), $request->request->get('_token'))) {
    //             $entityManager = $this->getDoctrine()->getManager();
    //             $entityManager->remove($emprunt);
    //             $entityManager->flush();
    //         }

    //         return $this->redirectToRoute('emprunt_index');
    //     }
}
