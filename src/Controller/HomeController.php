<?php

namespace App\Controller;

use Attribute;
use App\Entity\Objet;
use App\Entity\Emprunt;
use App\Entity\Categorie;
use App\Entity\SousCategorie;
use App\Form\EmpruntType;
use App\Repository\ObjetRepository;
use App\Repository\EmpruntRepository;
use App\Repository\AdherentRepository;
use App\Repository\CategorieRepository;
use App\Repository\SousCategorieRepository;
use App\Repository\SuperAdminRepository;
use App\Repository\PhotoRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;

class HomeController extends AbstractController
{
    // private $entityManager;
    //     public function __construct(EntityManagerInterface $entityManager)
    //     { $this->entityManager = $entityManager; }

    #[Route('/', name: 'home')]

    public function index(ObjetRepository $objetRepository, PhotoRepository $photoRepository, CategorieRepository $categorieRepository, SousCategorieRepository $sousCategorieRepository): Response
    {
        $objets = $objetRepository->findAll();
        $photos = $photoRepository->findAll();
        $categories = $categorieRepository->findAll();
        $sousCategories = $sousCategorieRepository->findAll();

        //  dd($sousCategories);

        return $this->render('home/catalogue.html.twig', [
            'controller_name' => 'HomeController',
            'objets' => $objets,
            'photos' => $photos,
            'categories' => $categories,
            'sousCategories' => $sousCategories,
        ]);
    }

    #[Route('/{slug}/detail', name: 'objetDetail', methods: ['GET', 'POST'])]
    public function detailsObjet(Objet $objet, EmpruntRepository $empruntRepository, Request $request, AdherentRepository $adherentRepository, SuperAdminRepository $superAdminRepository): Response

    {
        // foreach ($request->attributes->all() as $attribute) {
        // if ($attribute == $objet) {
        //     dump($objet->getId());
        // }
        // dump($attribute);
        // }
        // dump($request->attributes->all());
        // dump($session->all());


        $emprunt = new Emprunt();
        $form = $this->createForm(EmpruntType::class, $emprunt);
        $form->handleRequest($request);
        // // Je récupère l'adhérent et je vérifie si c'est un adhérent ou super-admin
        // dump($this->getUser()->getId());
        if ($this->getUser()) {
            $adherentBibliotheque = $this->getUser()->getId();
            $adherent = $adherentRepository->findOneById($adherentBibliotheque);
            $adminBibliotheque = $this->getUser()->getId();
            $admin = $superAdminRepository->findOneById($adminBibliotheque);

            $adherent
                ? $emprunt->setAdherent($adherent)
                : $emprunt->setSuperAdmin($admin);
        }


        if ($form->isSubmitted() && $form->isValid()) {


            if ($objet) {
                if ($objet->getStatut() == 'Disponible' || $objet->getStatut() == 'Réservé') {

                    // j'envoie en bdd l'objet
                    $emprunt->setObjet($objet);
                    // Je set la date de réservation uniquement si l'emprunt ne débute pas le jour même, et je la met à aujourd'hui
                    $now = new \DateTime();
                    if ($emprunt->getDateDebut() > $now) {
                        $emprunt->setDateReservation($now);
                    }
                    if ($emprunt->getDateFin() < $emprunt->getDateDebut()) {
                        $this->addFlash(
                            'danger',
                            "La date de fin d'emprunt ne peut pas être avant la date de début"
                        );
                    }

                    // calcul du prix de l'emprunt :
                    $obj = $emprunt->getObjet();
                    $days = $emprunt
                        ->getDateDebut()
                        ->diff($emprunt->getDateFin())->days;
                    $prix =
                        (((($obj->getValeurAchat() *
                            $obj->getPourcentCalcul()) /
                            100) *
                            $obj->getCoefUsure()) /
                            5) *
                        $days;
                    $emprunt->setPrixEmprunt($prix);

                    // calcul du montant de dépôt de garantie à rajouter au dépôt permanent :
                    $finrc = $adherent
                        ->getAdhesionBibliotheque()
                        ->getFinRc();
                    $depot_perm = $adherent
                        ->getAdhesionBibliotheque()
                        ->getDepotPermanent();

                    if ($adherent) {
                        if ($finrc > $now) {
                            $depot_rajoute =
                                ($obj->getValeurAchat() *
                                    $obj->getCoefUsure()) /
                                5 /
                                3 -
                                $depot_perm;
                            dump('rc valide');
                        } else {
                            $depot_rajoute =
                                ($obj->getValeurAchat() *
                                    $obj->getCoefUsure()) /
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
                    // valeur provisoire à 0 pour réglé des bugs
                    // $emprunt->setDepotRajoute(0);

                    // le statut de l'emprunt est mis "en attente de validation"
                    $emprunt->setStatut("demande avant panier");

                    dump($emprunt);
                    $entityManager = $this->getDoctrine()->getManager();
                    $entityManager->persist($emprunt);
                    $entityManager->flush();

                    return $this->redirectToRoute('home');
                }
            }
        }
        dump($emprunt);

        return $this->render('home/detailsObjet.html.twig', [
            'controller_name' => 'HomeController',
            'objet' => $objet,
            'emprunt' => $empruntRepository,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/panier', name: 'panier')]
    public function panierIndex(EmpruntRepository $empruntRepository, ObjetRepository $objetRepository, SousCategorieRepository $sousCategorieRepository, CategorieRepository $categorieRepository): Response
    {
        // if ($this->getUser()) {
        //     $adherentBibliotheque = $this->getUser()->getId();
        //     $adherent = $adherentRepository->findOneById($adherentBibliotheque);
        //     $adminBibliotheque = $this->getUser()->getId();
        //     $admin = $superAdminRepository->findOneById($adminBibliotheque);

        //     if ($adherent) {
        //         $adherentAdmin = $adherent;
        //     } else {
        //         $adherentAdmin = $admin;
        //     }
        // }

        return $this->render('home/panier.html.twig', [
            'controller_name' => 'HomeController',
            'emprunts' => $empruntRepository->findAll(),
            // 'adherent' => $adherentAdmin,
            'objets' => $objetRepository->findAll(),
            'sousCategories' => $sousCategorieRepository->findAll(),
            'categories' => $categorieRepository->findAll()
        ]);
    }

    #[Route('/historique_panier', name: 'historiquePanier')]
    public function historiquePanierIndex(): Response
    {
        return $this->render('home/historiquePanier.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    // #[Route('/catalogue', name: 'catalogue')]
    // public function catalogue(): Response
    // {
    //     return $this->render('home/catalogue.html.twig', [
    //         'controller_name' => 'CatalogueController',
    //     ]);
    // }

    #[Route('/mon_compte', name: '/mon_compte')]
    public function catalogue(): Response
    {
        return $this->render('home/compte.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    #[Route('/validation_panier', name: 'validation')]
    public function validationPanier(Request $request, EmpruntRepository $empruntRepository, ObjetRepository $objetRepository, SousCategorieRepository $sousCategorieRepository, CategorieRepository $categorieRepository, AdherentRepository $adherentRepository, SuperAdminRepository $superAdminRepository): Response
    {
        // dump($this->getUser()->getId());
        $emprunts = $empruntRepository->findAll();
        foreach ($emprunts as $emprunt) {
            // dump($emprunt->getAdherent());
            if ($this->getUser()) {
                $adherentBibliotheque = $this->getUser()->getId();
                $adherent = $adherentRepository->findOneById($adherentBibliotheque);
                $adminBibliotheque = $this->getUser()->getId();
                $admin = $superAdminRepository->findOneById($adminBibliotheque);
                $adherent
                    ? $emprunt->getAdherent($adherent)
                    : $emprunt->getSuperAdmin($admin);
                // dump($adherent->getId());
                if ($adherent->getId() == $this->getUser()->getId()) {
                    dump($emprunt);
                }
            }
            // if ($this->getUser()->getId() == $emprunt->getAdherent()->getId()) {
            //     dump($emprunt);
            // }
        }
        // dump($emprunt);
        // $emprunt->setStatut("en attente de validation");
        // dump($emprunt);
        // $entityManager = $this->getDoctrine()->getManager();
        // $entityManager->persist($emprunt);
        // $entityManager->flush();
        // $this->addFlash('success', "Votre demande d'emprunt a bien été prise en compte.");
        // dd($emprunt);
        return $this->render('home/panier.html.twig', [
            'controller_name' => 'HomeController',
            'emprunts' => $empruntRepository->findAll(),
            'objets' => $objetRepository->findAll(),
            'sousCategories' => $sousCategorieRepository->findAll(),
            'categories' => $categorieRepository->findAll()
        ]);
    }
}
