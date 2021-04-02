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


class AdherentFixtures extends Fixture
{


    public function random_dates($start, $end)
    {
        
        $dates = mt_rand(strtotime($start), strtotime($end));
        $defDates = date("Y/m/d", $dates);
        return new DateTime($defDates);
    }

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');
        $genders = ['male', 'female'];
        $fourmis = ['Verte', 'Bleue', 'Dorée'];
               

        for($i=0; $i<10; $i++){
            $adherent = new Adherent();
            $dateNais = $this->random_dates("01-01-1950", "01-01-2010");
            $gender = $faker->randomElement($genders);
            $fourmi = $faker->randomElement($fourmis);
            $adherent->setNom($faker->lastname())
                    ->setPrenom($faker->firstname($gender))
                    ->setEmail($faker->email())
                    ->setAdresse($faker->streetAddress)
                    ->setCP("13200")
                    ->setVille("Arles")
                    ->setEmail($faker->email)
                    ->setTelephone($faker->phoneNumber)
                    ->setDateNaissance($dateNais)
                    ->setLieuNaissance($faker->city())
                    ->setCategorieFourmi($fourmi)
                    ->setMontantCotisation($fourmi == "Dorée" ? 50 : 10)
                    ->setMoyenPaiement('Liquide')
                    ->setCompteActif($faker->boolean(95))
                    ->setAdmin($faker->boolean(70))
                    ->initSlug();

                    $this->addReference('adherent_' . $i, $adherent);
                    $manager->persist($adherent);
        }


        $manager->flush();
    }
  

}