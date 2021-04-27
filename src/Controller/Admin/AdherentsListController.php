<?php

namespace App\Controller\Admin;

use App\Entity\Adherent;
use App\Form\FilterType;
use App\Form\BiblioFormType;
use App\Form\AdhesionFormType;
use App\Entity\AdhesionBibliotheque;
use App\Repository\AdherentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Repository\AdhesionBibliothequeRepository;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdherentsListController extends AbstractController
{
    #[Route('/admin/adherents/list', name: 'admin_adherents_list')]
    
    public function index(AdherentRepository $repo, AdhesionBibliothequeRepository $adh, Request $request): Response
    {
        $adherents = $repo->findAll();
        $route = "down";

        // $fourmi = new AdhesionBibliotheque();

        // $form = $this->createForm(FilterType::class, $fourmi);

        // $form->handleRequest($request);
        // $adherents = $adh->filterOut($fourmi);

        return $this->render('admin/lists/adherents_list.html.twig', [
            'controller_name' => 'AdherentsListController',
            'adherents' => $adherents,
            'route' => $route,
            'section' => 'section-adherents',
            'return_path' => 'menu-adherent',
            'color' => 'adherents-color',
            // 'form' => $form->createView(),
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

    #[Route('/admin/adherents/new', name: 'admin_adherents_new')]

    public function newAdherent(Request $request, EntityManagerInterface $manager, ValidatorInterface $validator): Response
     {
         $adherent = new Adherent();
         
         $form = $this->createForm(AdhesionFormType::class, $adherent);

         $form->handleRequest($request);

         $submitted = "";
         
 if ($form->isSubmitted() ){

     $submitted = "was-validated"  ;
 }
    
        

    
        if ($form->isSubmitted() && $form->isValid()) {
            
            $adherent->setCompteActif(true);
            $manager->persist($adherent);
            $manager->flush();
 
    
    $biblio = $request->request->get('biblio');

    if($biblio == "oui") {
        return $this->redirectToRoute('adherents_new_biblio', [
        'id' => $adherent->getId(),
         ]);
    } elseif($biblio == "non") {
        
        $this->addFlash('success', "Le nouvel adhérent {$adherent->getNomprenom()} a bien été créé");
    }
          
         }         
        return $this->render('admin/forms/adherents_new.html.twig', [
            'controller_name' => 'AdherentsListController',
            'adherent' => $adherent,
            'arrow' => true,
            'section' => 'section-adherents',
            'return_path' => 'menu-adherent',
            'color' => 'adherents-color',
            'form' => $form->createView(),
            'submitted' => $submitted
         ]);
    }

    #[Route('/admin/adherents/new/biblio/{id}', name: 'adherents_new_biblio')]

    public function newBiblio($id, AdherentRepository $adherentRepository, Request $request, EntityManagerInterface $manager): Response
     {
        $adherent = $adherentRepository->findOneById($id);
         $biblio = new AdhesionBibliotheque();
         
         $form = $this->createForm(BiblioFormType::class, $biblio);

         $form->handleRequest($request);

            
        if ($form->isSubmitted()  && $form->isValid()) {
             $biblio->setAdherent($adherent);
            $biblio->setSatutInscription("valide");
           $biblio->setMotDePasse($adherent->getNom() . date_format( $adherent->getDateNaissance(), "Y"));
            $manager->persist($biblio);
            $manager->flush();

    
        $this->addFlash('success', "L'adhérent {$biblio->getAdherent()->getPrenom()} {$biblio->getAdherent()->getNom()}  est bien inscrit à la bibliothèque et son adhésion est bien prise en compte");
    
         }
        
        return $this->render('admin/forms/adherents_biblio.html.twig', [
            'controller_name' => 'AdherentsListController',
            'biblio' => $biblio,
            'arrow' => true,
            'adherent' => $adherent,
            'section' => 'section-adherents',
            'return_path' => 'menu-adherent',
            'color' => 'adherents-color',
            'form' => $form->createView()
        ]);
    }
}