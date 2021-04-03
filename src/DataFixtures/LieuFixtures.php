<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Lieu;
use App\Entity\Objet;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use App\DataFixtures\SousCategoriesFixtures;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;


class LieuFixtures extends Fixture implements DependentFixtureInterface
{

    public function load(ObjectManager $manager)
    {

        
   
        $lieu = new Lieu();
        
        $lieu->setNom("Kikassi-kikassa")
            ->setAdresse()
            ->setCp()
            ->setVille()
            ->setTelephone()
            ->setRaisonFermeture();


    $manager->persist($lieu);
    

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