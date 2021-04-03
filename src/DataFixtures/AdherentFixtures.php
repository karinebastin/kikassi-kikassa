<?php

namespace App\DataFixtures;

use DateTime;
use Faker\Factory;
use App\Entity\Adherent;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;


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
        $etats_cotisation = ['Payée', 'Due', 'Exonéré'];

        for($i=0; $i<10; $i++){
            $adherent = new Adherent();
            $dateNais = $this->random_dates("01-01-1950", "01-01-2010");
            $gender = $faker->randomElement($genders);
            $fourmi = $faker->randomElement($fourmis);
            $etat_cotisation = $faker->randomElement($etats_cotisation);
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
                    ->setEtatCotisation($etat_cotisation)
                    ->setCompteActif($faker->boolean(95))
                    ->setAdmin($faker->boolean(70))
                    ->initSlug();

                    $this->addReference('adherent_' . $i, $adherent);
                    $manager->persist($adherent);
        }


        $manager->flush();
    }

}