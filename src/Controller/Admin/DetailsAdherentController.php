<?php

namespace App\Controller\Admin;

use DateInterval;
use App\Entity\Adherent;
use App\Form\AllFormType;
use App\Form\BiblioFormType;
use App\Form\SearchFormType;
use App\Form\AdhesionFormType;
use App\Entity\AdhesionBibliotheque;
use App\Repository\AdherentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Form\ClickableInterface;

class DetailsAdherentController extends AbstractController
{
    #[Route('/admin/details/adherent/{slug}', name: 'admin_adherents_details')]
    public function index(
        $slug,
        AdherentRepository $adherentRepository,
     
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
    #[Route('/admin/adherents/modif', name: 'admin_adherents_modif')]
    public function selectModif(
        AdherentRepository $adherentRepository,
        Request $request,
    ): Response {
        $formSearch = $this->createForm(SearchFormType::class);

        $formSearch->handleRequest($request);

        $adherent = $adherentRepository->findOneById(
            $request->request->get('adherent')
        );
        if($adherent) {
        return $this->redirectToRoute('admin_adherents_edit', [
        'slug' => $adherent->getSlug(),
        ]);

}
       

        return $this->render('admin/forms/adherents_modif.html.twig', [
            'controller_name' => 'DetailsAdherentController',
            'return_path' => 'menu-adherent',
            'section' => 'section-adherents',
            'color' => 'adherents-color',
            'formSearch' => $formSearch->createView(),
            
        ]);
    }

    #[Route('/admin/adherents/edit/{slug}', name: 'admin_adherents_edit')]

    public function editAdherent(
        Adherent $adherent,
        Request $request,
        EntityManagerInterface $manager
        ): Response {

            // Si l'adhésion de l'adhérent date de + d'un an :
        $perime = false;
        $now = new \DateTime();
        $date = $adherent->getDateAdhesion();
        $nextYear = $date->add(new DateInterval('P1Y'));
        if ($adherent->getDateAdhesion()) {
            if ($nextYear < $now) {
                $perime = true;
                $adherent->setCompteActif(false);
                // pour l'affichage :
                $adherent->setMontantCotisation(0);
                $adherent->setEtatCotisation('');
                $adherent->setMoyenPaiement('');
                $nextYear = $date->sub(new DateInterval('P1Y'));
            }
        }

        $form = $this->createForm(AdhesionFormType::class, $adherent);

        $form->handleRequest($request);

        $submitted = $form->isSubmitted() ? 'was-validated' : '';

        if ($form->isSubmitted() && $form->isValid() ) {
            if ($nextYear < $now) {
                $adherent->setCompteActif(true);
                $adherent->setDateAdhesion($now);
            }
     
            $manager->persist($adherent);
            $manager->flush();

            if($adherent->getAdhesionBibliotheque()) {
                  /** @var ClickableInterface $button  */
             $button = $form->get("saveAndContinue");
            return $button->isClicked() ? $this->redirectToRoute('admin_adherents_edit_bilio', [
                'id' => $adherent->getId()]) :  $this->redirectToRoute('admin_adherents_details', [
                'slug' => $adherent->getSlug(),
            ]);
            } else {
                 /** @var ClickableInterface $button  */
             $button = $form->get("saveAndContinue");
            if($button->isClicked()) {
                
            return $this->redirectToRoute('adherents_new_biblio', [
                 'id' => $adherent->getId()]);
            } else {
                $this->addFlash(
                    'success',
                    "L'adhérent : {$adherent->getNomprenom()} a bien été mis à jour"
                );
                return  $this->redirectToRoute('admin_adherents_details', [
                 'slug' => $adherent->getSlug(),
             ]);
            }
             
            }
     
        }
        return $this->render('admin/forms/adherents_edit.html.twig', [
            'controller_name' => 'AdherentsListController',
            'adherent' => $adherent,
            'arrow' => true,
            'section' => 'section-adherents',
            'return_path' => 'menu-adherent',
            'color' => 'adherents-color',
            'form' => $form->createView(),
            'submitted' => $submitted,
            'perime' => $perime
        ]);
    }


    #[Route('/admin/adherents/edit/biblio/{id}', name:'admin_adherents_edit_bilio')]

    public function editBiblioAdherent(
        $id,
        AdherentRepository $adherentRepository,
        Request $request,
        EntityManagerInterface $manager,
        UserPasswordEncoderInterface $encoder
    ): Response {

        $adherent = $adherentRepository->findOneById($id);
        $biblio = $adherent->getAdhesionBibliotheque();

        $admin = $request->request->get('admin');
        $admin == 'oui'
            ? $biblio->setRoles(['ROLE_ADMIN'])
            : $biblio->setRoles(['ROLE_USER']);

        $form = $this->createForm(BiblioFormType::class, $biblio);

        $form->handleRequest($request);

        $submitted = $form->isSubmitted() ? 'was-validated' : '';

        if ($form->isSubmitted() && $form->isValid()) {
            $biblio->setAdherent($adherent);
            $biblio->setEmail($adherent->getEmail());
            $biblio->setSatutInscription('valide');
            $hash = $encoder->encodePassword(
                $biblio,
                $adherent->getNom() .
                    date_format($adherent->getDateNaissance(), 'Y')
            );

            $biblio->setMotDePasse($hash);
            $manager->persist($biblio);
            $manager->flush();

            $this->addFlash(
                'success',
                "Les changements dans l'Inscription à la Bibliothèque des Objets de {$biblio->getAdherent()->getPrenom()} {$biblio->getAdherent()->getNom()} sont bien prises en compte"
            );
            return $this->redirectToRoute('admin_adherents_details', [
                'slug' => $adherent->getSlug(),
            ]);
        }

        return $this->render('admin/forms/adherents_biblio.html.twig', [
            'controller_name' => 'AdherentsListController',
            'biblio' => $biblio,
            'arrow' => true,
            'adherent' => $adherent,
            'section' => 'section-adherents',
            'return_path' => 'menu-adherent',
            'color' => 'adherents-color',
            'submitted' => $submitted,
            'form' => $form->createView(),
        ]);

    }

    





    
       
}