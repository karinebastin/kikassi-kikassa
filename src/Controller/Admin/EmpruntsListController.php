<?php

namespace App\Controller\Admin;

use App\Entity\Emprunt;
use App\Form\SearchFormType;
use App\Form\EmpruntFormType;
use App\Repository\ObjetRepository;
use App\Repository\EmpruntRepository;
use App\Repository\AdherentRepository;
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
        ObjetRepository $objetRepository
    ): Response {
        $emprunt = new Emprunt();
        $adherents = '';
        $objets = '';
        $adh = null;
        $obj = null;

        $formObjSearch = $this->createForm(SearchFormType::class);
        $formAdhSearch = $this->createForm(SearchFormType::class);
        $form = $this->createForm(EmpruntFormType::class, $emprunt);

        $formAdhSearch->handleRequest($request);

        /** @var Form $formAdhSearch */
        $buttonAdh = $formAdhSearch->getClickedButton();
        if (
            $buttonAdh &&
            $buttonAdh->getName() == 'search' &&
            $formAdhSearch->isSubmitted() &&
            $formAdhSearch->isValid()
        ) {
            $data = $formAdhSearch->getData();
            $adherents = $adherentRepository->findByNomPrenom($data['nom']);
        }

        if (
            $buttonAdh &&
            $buttonAdh->getName() == 'send' &&
            $formAdhSearch->isSubmitted() &&
            $formAdhSearch->isValid()
        ) {
            $adh = $adherentRepository->findOneById(
                $request->request->get('adherent-select')
            );
            $emprunt->setAdherent($adh);
            dump($emprunt);
        }

        $formObjSearch->handleRequest($request);

        /** @var Form $formObjSearch */
        $buttonObj = $formObjSearch->getClickedButton();

        if (
            $buttonObj &&
            $buttonObj->getName() == 'search' &&
            $formObjSearch->isSubmitted() &&
            $formObjSearch->isValid()
        ) {
            $data = $formObjSearch->getData();
            $objets = $objetRepository->findBy([
                'denomination' => $data['nom'],
            ]);
            $adh2 = $adherentRepository->findOneById(
                $request->request->get('adherent')
            );
        }

        if (
            $buttonObj &&
            $buttonObj->getName() == 'send' &&
            $formObjSearch->isSubmitted() &&
            $formObjSearch->isValid()
        ) {
            $obj = $objetRepository->findOneById(
                $request->request->get('objet-select')
            );
            $adh3 = $adherentRepository->findOneById(
                $request->request->get('adherent-deux')
            );
        }

        $form->handleRequest($request);

        $adher = $adherentRepository->findOneById($request->request->get('ad'));
        $emprunt->setAdherent($adher);

        $objt = $objetRepository->findOneById($request->request->get('objet'));
        $emprunt->setObjet($objt);

        $submitted = $form->isSubmitted() ? 'was-validated' : '';

        if ($form->isSubmitted() && $form->isValid()) {
            $emprunt->setStatut('Emprunt en cours');
            $emprunt->setDepotRajoute(30);
            $emprunt->setPrixEmprunt(2.3);
            $emprunt->setEmpruntRegle(false);
            $manager->persist($emprunt);

            $manager->flush();
        }

        return $this->render('admin/forms/emprunts_new.html.twig', [
            'controller_name' => 'EmpruntsListController',

            'adherents' => $adherents,
            'objets' => $objets,
            'arrow' => true,
            'section' => 'section-emprunts',
            'return_path' => 'menu-emprunt',
            'color' => 'emprunts-color',
            'form' => $form->createView(),
            'formObjSearch' => $formObjSearch->createView(),
            'formAdhSearch' => $formAdhSearch->createView(),
            'submitted' => $submitted,
            'adh' => $adh,
            'adh2' => $adh2,
            'adh3' => $adh3,
            'obj' => $obj,
        ]);
    }
}