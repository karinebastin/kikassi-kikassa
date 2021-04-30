<?php

namespace App\Controller\Admin;

use App\Entity\Adherent;
use App\Entity\Objet;
use App\Entity\Photo;
use App\Form\ObjetFormType;
use App\Form\SearchFormType;
use App\Repository\ObjetRepository;
use App\Repository\AdherentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\ClickableInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ObjetsListController extends AbstractController
{
    #[Route('/admin/objets/list', name: 'admin_objets_list')]
    public function index(ObjetRepository $repo): Response
    {
        $objets = $repo->findAll();
        $route = 'down';

        return $this->render('admin/lists/objets_list.html.twig', [
            'controller_name' => 'ObjetsListController',
            'objets' => $objets,
            'route' => $route,
            'section' => 'section-objets',
            'return_path' => 'menu-objet',
            'color' => 'objets-color',
        ]);
    }
    #[Route('/admin/details/objet/{slug}', name: 'admin_details_objet')]
    public function showDetails(
        $slug,
        ObjetRepository $objetRepository
    ): Response {
        $objet = $objetRepository->findOneBySlug($slug);

        return $this->render('admin/pages_details/details_objet.html.twig', [
            'controller_name' => 'DetailsObjetController',
            'objet' => $objet,
            'return_path' => 'menu-objet',
            'section' => 'section-objets',
            'color' => 'objets-color',
        ]);
    }

    #[Route('/admin/objets/list/{obj}/{order}', name: 'admin_objets_list_sort')]
    public function sortDataD($obj, $order, ObjetRepository $repo): Response
    {
        if ($order == 'up') {
            $objets = $repo->findBy([], [$obj => 'DESC']);
            $route = 'down';
        } else {
            $objets = $repo->findBy([], [$obj => 'ASC']);
            $route = 'up';
        }

        return $this->render('admin/lists/objets_list.html.twig', [
            'controller_name' => 'ObjetsListController',
            'objets' => $objets,
            'route' => $route,
            'section' => 'section-objets',
            'return_path' => 'menu-objet',
            'color' => 'objets-color',
        ]);
    }

    #[Route('/admin/objets/new', name: 'admin_objets_new')]

    public function newObjet(
        Request $request,
        EntityManagerInterface $manager,
        AdherentRepository $AdherentRepository
    ): Response {
        $objet = new Objet();
        $adherents = '';
        $adh = null;

        $formSearch = $this->createForm(SearchFormType::class);

        $form = $this->createForm(ObjetFormType::class, $objet);

        $formSearch->handleRequest($request);

        /** @var Form $formSearch */
        $button = $formSearch->getClickedButton();

        if (
            $button &&
            $button->getName() == 'search' &&
            $formSearch->isSubmitted() &&
            $formSearch->isValid()
        ) {
            $data = $formSearch->getData();
            $adherents = $AdherentRepository->findByNomPrenom($data['nom']);
        }

        if (
            $button &&
            $button->getName() == 'send' &&
            $formSearch->isSubmitted() &&
            $formSearch->isValid()
        ) {
            $adh = $AdherentRepository->findOneById(
                $request->request->get('adherent-select')
            );
        }

        $form->handleRequest($request);

        $adher = $AdherentRepository->findOneById(
            $request->request->get('adherent')
        );
        $objet->setAdherent($adher);

        $submitted = $form->isSubmitted() ? 'was-validated' : '';

        if ($form->isSubmitted() && $form->isValid()) {
            $directory = 'photos';

            $file = $form['photos']->getData();
            foreach ($file as $photo) {
                $extension = $photo->guessExtension();
                if (!$extension) {
                    $extension = 'bin';
                }

                $photoLien =
                    $objet->getDenomination() .
                    rand(1, 9999) .
                    '.' .
                    $extension;
                $photo->move($directory, $photoLien);

                $img = new Photo();
                $img->setLien($photoLien);
                $img->setObjet($objet);
                $manager->persist($img);
            }

            $objet->setStatut('Disponible');
            $manager->persist($objet);

            $manager->flush();

            // METTRE flash dans la page details objet

            $this->addFlash(
                'success',
                "Le nouvel objet : {$objet->getDenomination()} {$objet->getMarque()} a bien été créé"
            );
            return $this->redirectToRoute('admin_details_objet', [
                'slug' => $objet->getSlug(),
            ]);
        }

        return $this->render('admin/forms/objets_new.html.twig', [
            'controller_name' => 'ObjetsListController',

            'adherents' => $adherents,
            'arrow' => true,
            'section' => 'section-objets',
            'return_path' => 'menu-objet',
            'color' => 'objets-color',
            'form' => $form->createView(),
            'formSearch' => $formSearch->createView(),
            'submitted' => $submitted,
            'adh' => $adh,
        ]);
    }
}