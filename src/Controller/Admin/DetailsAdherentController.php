<?php

namespace App\Controller\Admin;

use DateInterval;
use App\Entity\Adherent;
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

class DetailsAdherentController extends AbstractController
{
    #[Route('/admin/details/adherent/{slug}', name: 'admin_details_adherent')]
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
            // 'slug' => $slug
        ]);
    }

    #[Route('/admin/adherents/edit/{slug}', name: 'admin_adherents_edit')]

    public function editAdherent(
        Adherent $adherent,
        ?AdhesionBibliotheque $biblio,
        Request $request,
        EntityManagerInterface $manager,
        UserPasswordEncoderInterface $encoder
    ): Response {
        // Si l'adhésion de l'adhérent date de + d'un an :
        $now = new \DateTime();
        $nextYear = $adherent->getDateAdhesion()->add(new DateInterval('P1Y'));
        if ($adherent->getDateAdhesion()) {
            if ($nextYear < $now) {
                $adherent->setCompteActif(false);
                // pour l'affichage :
                $adherent->setMontantCotisation(0);
                $adherent->setEtatCotisation('');
                $adherent->setMoyenPaiement('');
            }
        }

        if (
            !$adherent->getAdhesionBibliotheque() &&
            $request->request->get('biblio') == 'oui'
        ) {
            $biblio = new AdhesionBibliotheque();
            $biblio->setAdherent($adherent);
            $biblio->setEmail($adherent->getEmail());
            $biblio->setSatutInscription('valide');
            $hash = $encoder->encodePassword(
                $biblio,
                $adherent->getNom() .
                    date_format($adherent->getDateNaissance(), 'Y')
            );
        }

        $form = $this->createForm(AdhesionFormType::class, $adherent);
        $formBiblio = $this->createForm(BiblioFormType::class, $biblio);

        $form->handleRequest($request);
        $formBiblio->handleRequest($request);

        $submitted = $form->isSubmitted() ? 'was-validated' : '';

        if ($form->isSubmitted() && $form->isValid()) {
            if ($adherent->getAdhesionBibliotheque() || $biblio) {
                $admin = $request->request->get('admin');
                $admin == 'oui'
                    ? $biblio->setRoles(['ROLE_ADMIN'])
                    : $biblio->setRoles(['ROLE_USER']);
            }

            // si c'est un adhérent dont l'adhésion est périmée :
            if ($nextYear < $now) {
                $adherent->setCompteActif(true);
                $adherent->setDateAdhesion($now);
            }
            if ($biblio) {
                $biblio->setMotDePasse($hash);
                $manager->persist($biblio);
            }
            $manager->persist($adherent);
            $manager->flush();

            return $this->redirectToRoute('admin_adherents_edit', [
                'slug' => $adherent->getSlug(),
            ]);
        }
        return $this->render('admin/forms/adherents_edit.html.twig', [
            'controller_name' => 'AdherentsListController',
            'adherent' => $adherent,
            'arrow' => true,
            'section' => 'section-adherents',
            'return_path' => 'menu-adherent',
            'color' => 'adherents-color',
            'form' => $form->createView(),
            'formBiblio' => $formBiblio->createView(),
            'submitted' => $submitted,
        ]);
    }
}