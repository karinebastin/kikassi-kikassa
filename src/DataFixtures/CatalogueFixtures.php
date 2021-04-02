<?php

namespace App\DataFixtures;

use DateTime;
use Faker\Factory;
use App\Entity\Objet;
use App\Entity\Adherent;
use App\Entity\Catalogue;
use App\Entity\Categorie;
use App\Entity\SousCategorie;
use App\Entity\AdhesionBibliotheque;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class CatalogueFixtures extends Fixture
{
  
    public function load(ObjectManager $manager)
    {
      

   $catalogue1 = new Catalogue();
    $catalogue2 = new Catalogue();
    $catalogue1->setNomCatalogue("Vert");
    $catalogue2->setNomCatalogue("Bleu");

    $manager->persist($catalogue1, $catalogue2);

    $manager->flush();
                        }
                     
                    }