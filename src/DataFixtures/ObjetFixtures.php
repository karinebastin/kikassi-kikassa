<?php

namespace App\DataFixtures;

use DateTime;
use Faker\Factory;
use App\Entity\Objet;
use App\DataFixtures\AdherentFixtures;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class ObjetFixtures extends Fixture implements DependentFixtureInterface
{
 

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');

for($i=0; $i<10; $i++){ 
    $objet = new Objet(); 
    $lieu = $this->getReference('lieu_' . $i);
    $ssCategorie = $this->getReference('ssCategorie_' . $i);
    $objet->setDenomination($faker->boolean(70))
            ->setMarque()
            ->setDescription()
            ->setValeurAchat()
            ->setCoefUsure()
            ->setPourcentCalcul()
            ->setVitrine($faker->boolean(50))
            ->setSousCategorie($ssCategorie)
            ->setLieu($lieu)
            // ->setPhoto()
            // ->setCatalogue();
            ->setStatut()
            ->setObservation();

    $manager->persist($objet);
    }

    $manager->flush();
                        }
                        public function getDependencies()
                        {
                            return [
                                AdherentFixtures::class,
                            ];
                        }
                    }