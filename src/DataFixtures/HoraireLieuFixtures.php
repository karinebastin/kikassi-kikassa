<?php

namespace App\DataFixtures;

use DateTime;
use App\Entity\HoraireLieu;
use App\DataFixtures\LieuFixtures;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;


class HoraireLieuFixtures extends Fixture implements DependentFixtureInterface
{

    public function load(ObjectManager $manager)
    {

        function time($heure)
        {
        $h = strtotime($heure);
        return new DateTime(date("h:i", $h));
}

        $horaireMerc = new HoraireLieu();
        $horaireSam = new HoraireLieu();
        $lieu = $this->getReference('lieu');
    
        
        $horaireMerc->setjour("Mercredi")
            ->setOuvPm(time("12h00"))
            ->setFermePm(time("16h00"))
            ->setLieu($lieu);

        $horaireSam->setjour("Samedi")
            ->setOuvAm(time("10h00"))
            ->setFermeAm(time("13h00"))
            ->setLieu($lieu);

    $manager->persist($horaireMerc, $horaireSam);
    

    $manager->flush();
                        }
                        public function getDependencies()
                        {
                            return [
                                LieuFixtures::class
                            ];
                        }
                    }