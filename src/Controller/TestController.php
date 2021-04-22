<?php

namespace App\Controller;

use Omines\DataTablesBundle\DataTableFactory;
use Symfony\Component\HttpFoundation\Request;
use Omines\DataTablesBundle\Column\TextColumn;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Omines\DataTablesBundle\Adapter\ArrayAdapter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TestController extends AbstractController
{
    #[Route('/test', name: 'test')]
    // public function index(): Response
    // {
    //     return $this->render('test/index.html.twig', [
    //         'controller_name' => 'TestController',
    //     ]);
    // }

    public function showAction(Request $request, DataTableFactory $dataTableFactory)
    {
        $table = $dataTableFactory->create()
            ->add('id', TextColumn::class)
            ->add('nom', TextColumn::class)
            ->add('prenom', TextColumn::class)
            ->createAdapter(ArrayAdapter::class, [
                ['id' => '2', 'nom' => 'Trump', 'prenom' => 'D'],
                ['id' => '3', 'nom' => 'Obama', 'prenom' => 'O'],
            ])
            ->handleRequest($request);

        if ($table->isCallback()) {
            return $table->getResponse();
        }

        return $this->render('test/index.html.twig', ['datatable' => $table]);
    }

}