<?php

namespace App\DataFixtures;

use DateTime;
use Faker\Factory;
use App\Entity\AdhesionBibliotheque;
use App\DataFixtures\AdherentFixtures;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class InscriptionFixtures extends Fixture implements DependentFixtureInterface
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function random_dates($start, $end)
    {
        
        $dates = mt_rand(strtotime($start), strtotime($end));
        $defDates = date("Y/m/d", $dates);
        return new DateTime($defDates);
    }

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');
        $depot = [30, 60, 90, 120];
        $fourmis = ['Verte', 'Bleue', 'Dorée'];


for($i=0; $i<10; $i++){ 
    $biblio = new AdhesionBibliotheque(); 
    $finRc = $this->random_dates("03-04-2021", "02-04-2022");
    $mdp = $this->encoder->encodePassword($biblio, 'password');
    $fourmi = $faker->randomElement($fourmis);
    $adh = $this->getReference('adherent_' . $i);
    $biblio->setMotDePasse($mdp)
    ->setDepotPermanent($faker->randomElement($depot))
    ->setFinRc($finRc)
    ->setJustifIdentite($faker->boolean(70))
    ->setJustifDomicile($faker->boolean(70))
    ->setSatutInscription('valide')
    ->setCategorieFourmi($fourmi)
    ->setAdherent($adh);
    $manager->persist($biblio);
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