<?php

namespace App\Controller\Admin;

use App\Entity\Objet;
use App\Entity\Photo;
use App\Form\ObjetFormType;
use App\Repository\AdherentRepository;
use App\Repository\ObjetRepository;
use Doctrine\ORM\EntityManagerInterface;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\ClickableInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
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
        $formSearch = $this->createFormBuilder()
            ->add('nom', TextType::class)
            ->add('search', SubmitType::class, [
                'label' => '<div class="btn-text p-1 px-2">Ok</div>',
                'label_html' => true,
                'attr' => ['class' => 'envoi-btn font-raleway'],
            ])
            ->getForm();

        $formSearch->handleRequest($request);
        $adherents = '';

        if ($formSearch->isSubmitted() && $formSearch->isValid()) {
            $data = $formSearch->getData();
            if (
                $AdherentRepository->findBy([
                    'nom' => $data,
                ]) != null
            ) {
                $adherents = $AdherentRepository->findBy([
                    'nom' => $data,
                ]);
            } elseif (
                $AdherentRepository->findBy([
                    'prenom' => $data,
                ]) != null
            ) {
                $adherents = $AdherentRepository->findBy([
                    'prenom' => $data,
                ]);
            } else {
                $adherents = 'non trouvé';
            }

            dump($adherents);
        }

        $objet = new Objet();

        $form = $this->createForm(ObjetFormType::class, $objet);

        $form->handleRequest($request);

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
            'objet' => $objet,
            'adherents' => $adherents,
            'arrow' => true,
            'section' => 'section-objets',
            'return_path' => 'menu-objet',
            'color' => 'objets-color',
            'form' => $form->createView(),
            'formSearch' => $formSearch->createView(),
            'submitted' => $submitted,
        ]);
    }

    // public function contact(Request $request): Response
    //     {
    //         $defaultData = ['message' => 'Type your message here'];
    //         $form = $this->createFormBuilder($defaultData)
    //             ->add('name', TextType::class)
    //             ->add('email', EmailType::class)
    //             ->add('message', TextareaType::class)
    //             ->add('send', SubmitType::class)
    //             ->getForm();

    //         $form->handleRequest($request);

    //         if ($form->isSubmitted() && $form->isValid()) {
    //             // data is an array with "name", "email", and "message" keys
    //             $data = $form->getData();
    //         }

    //         // ... render the form
    //     }
}