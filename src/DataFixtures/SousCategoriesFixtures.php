<?php

namespace App\DataFixtures;

use App\Entity\SousCategorie;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;


class SousCategoriesFixtures extends Fixture implements DependentFixtureInterface
{

    public function load(ObjectManager $manager)
    {

    $sscat = ['ssCatBrico' => ["Outils à main", "Machines"],
    'ssCatCuisine' => ["Entretien", "ustensils", "robots"],
    'ssCatLoisirs' => ["Livres", "Jouets", "Jardinage"]];

    $i = 0;
    foreach($sscat as $key){
        foreach($key as $val) {
            $sscate = new SousCategorie();
            $sscate->setNomSsCategorie($val)
            ->setCategorie($this->getReference('categorie_' . $i))
            ->initSlug();
            $manager->persist($sscate);
        }
            $i++;
          
      }
    
      $manager->flush();

                        }
                        
                        public function getDependencies()
                        {
                            return [
                                CategoriesFixtures::class,
                            ];
                        
                    }

                    }