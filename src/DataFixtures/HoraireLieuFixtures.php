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


        $horaireMerc = new HoraireLieu();
        $horaireSam = new HoraireLieu();
        $lieu = $this->getReference('lieu');
    
        
        $horaireMerc->setjour("Mercredi")
            ->setOuvPm("12h00")
            ->setFermePm("16h00")
            ->setLieu($lieu);

        $horaireSam->setjour("Samedi")
            ->setOuvAm("10h00")
            ->setFermeAm("13h00")
            ->setLieu($lieu);

    $manager->persist($horaireMerc);
    $manager->persist($horaireSam);
    

    $manager->flush();
                        }
                        public function getDependencies()
                        {
                            return [
                                LieuFixtures::class
                            ];
                        }
                    }