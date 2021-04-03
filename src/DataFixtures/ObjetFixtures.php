<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Objet;
use App\DataFixtures\LieuFixtures;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use App\DataFixtures\SousCategoriesFixtures;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;


class ObjetFixtures extends Fixture implements DependentFixtureInterface
{

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');
        $pourcentCalcul = [1, 1.5, 2];
        $statut = ["Réservé", "En maintenance", "Disponible"];
        
    for($i=0; $i<10; $i++){ 
        $objet = new Objet();
        $lieu = $this->getReference('lieu');
        $ssCategorie = $this->getReference('ssCategorie_' . $i);
        $objet->setDenomination($faker->word)
            ->setMarque($faker->word)
            ->setDescription($faker->sentence($nbWords = 16, $variableNbWords = true))
            ->setValeurAchat(rand(20, 120))
            ->setCoefUsure(rand(1,5))
            ->setPourcentCalcul($faker->randomElement($pourcentCalcul))
            ->setVitrine($faker->boolean(50))
            ->setSousCategorie($ssCategorie)
            ->setLieu($lieu)
            // ->setPhoto()
            // ->setCatalogue();
            ->setStatut($faker->randomElement($statut))
            ->setObservation($faker->sentence($nbWords = 10, $variableNbWords = true));

    $manager->persist($objet);
    }

    $manager->flush();
            }
                        public function getDependencies()
                        {
                            return [
                                LieuFixtures::class,
                                SousCategoriesFixtures::class
                            ];
                        }
                    }