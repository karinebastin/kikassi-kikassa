<?php

namespace App\Controller\Admin;

use App\Entity\Emprunt;
use App\Entity\Objet;
use App\Form\SearchFormType;
use App\Form\EmpruntFormType;
use App\Repository\ObjetRepository;
use App\Repository\EmpruntRepository;
use App\Repository\AdherentRepository;
use App\Repository\SuperAdminRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class EmpruntsListController extends AbstractController
{
    #[Route('/admin/emprunts/list', name: 'admin_emprunts_list')]
    public function index(EmpruntRepository $repo): Response
    {
        $emprunts = $repo->findAll();

        return $this->render('admin/lists/emprunts_list.html.twig', [
            'controller_name' => 'EmpruntsListController',
            'emprunts' => $emprunts,
            'section' => 'section-emprunts',
            'return_path' => 'menu-emprunt',
            'color' => 'emprunts-color',
        ]);
    }
    #[Route('/admin/emprunts/new', name: 'admin_emprunts_new')]

    public function newEmprunt(
        Request $request,
        EntityManagerInterface $manager,
        AdherentRepository $adherentRepository,
        ObjetRepository $objetRepository,
        SuperAdminRepository $superAdminRepository
    ): Response {
        $emprunt = new Emprunt();
        $objet = new Objet();
        $formObjSearch = $this->createForm(SearchFormType::class);
        $formSearch = $this->createForm(SearchFormType::class);
        $form = $this->createForm(EmpruntFormType::class, $emprunt);

        $form->handleRequest($request);

        $adherent = $adherentRepository->findOneById(
            $request->request->get('adherent')
        );
        $admin = $superAdminRepository->findOneById(
            $request->request->get('adherent')
        );

        $adherent
            ? $emprunt->setAdherent($adherent)
            : $emprunt->setSuperAdmin($admin);

        $objet = $objetRepository->findOneById($request->request->get('objet'));
        $emprunt->setObjet($objet);
        $submitted = $form->isSubmitted() ? 'was-validated' : '';

        if ($form->isSubmitted() && $form->isValid()) {
            if (($adherent && $adherent->getAdhesionBibliotheque()) || $admin) {
                $now = new \DateTime();
                if ($emprunt->getDateDebut() > $now) {
                    $emprunt->setDateReservation($now);
                }
                if ($emprunt->getDateFin() < $emprunt->getDateDebut()) {
                    $this->addFlash(
                        'danger',
                        "La date de fin d'emprunt ne peu pas être avant la date de début"
                    );
                }
                $emprunt->setStatut(
                    $emprunt->getDateDebut() == $now
                        ? 'Emprunt en cours'
                        : 'Accepté par l\'Admin'
                );

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
                $emprunt->setPenalites($emprunt->getEmpruntRegle() ? 0 : $prix);

                $finrc = $adherent->getAdhesionBibliotheque()->getFinRc();
                $depot_perm = $adherent
                    ->getAdhesionBibliotheque()
                    ->getDepotPermanent();

                if ($adherent) {
                    if ($finrc > $now) {
                        $depot_rajoute =
                            ($obj->getValeurAchat() * $obj->getCoefUsure()) /
                                5 /
                                3 -
                            $depot_perm;
                        dump('rc valide');
                    } else {
                        $depot_rajoute =
                            ($obj->getValeurAchat() * $obj->getCoefUsure()) /
                                5 -
                            $depot_perm;
                        dump('pas rc ou rc perimee');
                    }
                } else {
                    $depot_rajoute = 0;
                    dump('est admin');
                }

                $emprunt->setDepotRajoute(
                    $depot_rajoute < 0 ? 0 : $depot_rajoute
                );
                $objet->setStatut('réservé');
                $manager->persist($emprunt);
                $manager->flush();
            } else {
                $this->addFlash(
                    'danger',
                    "Emprunt impossible, <br> L'adhérent {$adherent->getNomprenom()} n'est pas inscrit à la bibliothèque"
                );
            }
        }

        return $this->render('admin/forms/emprunts_new.html.twig', [
            'controller_name' => 'EmpruntsListController',
            'arrow' => true,
            'section' => 'section-emprunts',
            'return_path' => 'menu-emprunt',
            'color' => 'emprunts-color',
            'form' => $form->createView(),
            'formObjSearch' => $formObjSearch->createView(),
            'formSearch' => $formSearch->createView(),
            'submitted' => $submitted,
        ]);
    }
}