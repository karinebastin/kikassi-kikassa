<?php

namespace App\Controller;

use App\Entity\Objet;
use App\Entity\Emprunt;
use App\Form\EmpruntType;
use App\Entity\SuperAdmin;
use App\Repository\ObjetRepository;
use App\Entity\AdhesionBibliotheque;
use App\Repository\EmpruntRepository;
use App\Repository\AdherentRepository;
use App\Repository\SuperAdminRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\AdhesionBibliothequeRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
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

    #[Route('/new/{slug}', name: 'emprunt_new', methods: ['GET', 'POST'])]
    public function new(
        Request $request,
        Objet $objet,
        AdherentRepository $adherentRepository,
        EntityManagerInterface $manager
    ): Response {
        $emprunt = new Emprunt();
        $form = $this->createForm(EmpruntType::class, $emprunt);
        $form->handleRequest($request);
        $adhesion = $this->getUser();

        // Je récupère l'adhérent et je vérifie si c'est un adhérent ou super-admin
        if ($adhesion) {
            $adherent = $adherentRepository->findOneById(
                $adhesion->getAdherent()->getId()
            );

            $emprunt->setObjet($objet);
            $emprunt->setAdherent($adherent);

            if ($form->isSubmitted() && $form->isValid()) {
                $now = new \DateTime();
                $emprunt->setDateReservation($now);

                //   calcul du prix de l'emprunt :

                $obj = $emprunt->getObjet();

                $days = $emprunt->getDateDebut()->diff($emprunt->getDateFin())
                    ->days;
                $prix =
                    (((($obj->getValeurAchat() * $obj->getPourcentCalcul()) /
                        100) *
                        $obj->getCoefUsure()) /
                        5) *
                    $days;
                $emprunt->setPrixEmprunt($prix);

                // calcul du montant de dépôt de garantie à rajouter au dépôt permanent :

                $finrc = $adherent->getAdhesionBibliotheque()->getFinRc();

                $depot_perm = $adherent
                    ->getAdhesionBibliotheque()
                    ->getDepotPermanent();

                if ($finrc > $now) {
                    $depot_rajoute =
                        ($obj->getValeurAchat() * $obj->getCoefUsure()) /
                        5 /
                        3 -
                        $depot_perm;
                    dump('rc valide');
                } else {
                    $depot_rajoute =
                        ($obj->getValeurAchat() * $obj->getCoefUsure()) / 5 -
                        $depot_perm;
                    dump('pas rc ou rc perimee');
                }

                $emprunt->setDepotRajoute(
                    $depot_rajoute < 0 ? 0 : $depot_rajoute
                );

                $emprunt->setStatut('en attente de validation');
                $emprunt->setEmpruntRegle(false);
                $manager->persist($emprunt);
                $manager->flush();

                dump($emprunt);
            }

            return $this->render('emprunt/new.html.twig', [
                'emprunt' => $emprunt,
                'form' => $form->createView(),
            ]);
        } else {
            return $this->redirectToRoute('app_login');
        }
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
