<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Categorie;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;


class CategoriesFixtures extends Fixture
{
  
    public function load(ObjectManager $manager)
    {

        $categorie = ["Bricolage", "Cuisine", "Loisirs"];

        for($i=0; $i<count($categorie); $i++) { 
        $cate = new Categorie();
        $cate->setNomCategorie($categorie[$i])
        ->initSlug();
        $this->addReference('categorie_' . $i, $cate);
    
        $manager->persist($cate);

        }

        $manager->flush();
        }
                        
                      
                }