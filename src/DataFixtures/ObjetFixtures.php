<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Objet;
use App\DataFixtures\LieuFixtures;
use App\DataFixtures\CatalogueFixtures;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use App\DataFixtures\SousCategoriesFixtures;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;


class ObjetFixtures extends Fixture implements DependentFixtureInterface
{

     public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');
        $objet = ["marteau","perceuse","aspirateur", "casseroles", "robot", "livre", "jouet", "tondeuse"]; 
        $pourcentCalcul = [1, 1.5, 2];
        $statut = ["Réservé", "En maintenance", "Disponible"];
        
    for($i=0; $i<count($objet); $i++){ 
        $objet = new Objet();
        $lieu = $this->getReference('lieu');
        $ssCategorie = $this->getReference('ssCategorie_' . $i);
        $catalogues =  [$this->getReference('vert'),  $this->getReference('bleu')];
        $objet->setDenomination($objet[$i])
            ->setMarque($faker->word)
            ->setDescription($faker->sentence($nbWords = 16, $variableNbWords = true))
            ->setValeurAchat(rand(20, 120))
            ->setCoefUsure(rand(1,5))
            ->setPourcentCalcul($faker->randomElement($pourcentCalcul))
            ->setVitrine($faker->boolean(50))
            ->setSousCategorie($ssCategorie)
            ->setLieu($lieu)
            ->addCatalogue($faker->randomElement($catalogues))
            ->setStatut($faker->randomElement($statut))
            ->setObservation($faker->sentence($nbWords = 10, $variableNbWords = true));
        
            $this->addReference('objet_' . $i, $objet);
    $manager->persist($objet);
    }

    $manager->flush();
            }
                        public function getDependencies()
                        {
                            return [
                                LieuFixtures::class,
                                SousCategoriesFixtures::class,
                                CatalogueFixtures::class
                            ];
                        }
                    }