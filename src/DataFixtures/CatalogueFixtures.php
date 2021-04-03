<?php

namespace App\DataFixtures;

use App\Entity\Catalogue;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;


class CatalogueFixtures extends Fixture
{
  
    public function load(ObjectManager $manager)
    {

    $vert = new Catalogue();
    $vert->setNomCatalogue("Vert");
    $bleu = new Catalogue();
    $bleu->setNomCatalogue("Bleu");

    $manager->persist($vert, $bleu);

    $manager->flush();
                        }
                    }