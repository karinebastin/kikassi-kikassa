<?php

namespace App\DataFixtures;

use App\Entity\SuperAdmin;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class SuperAdminFixtures extends Fixture
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }
   
    public function load(ObjectManager $manager)
    {
            $marvie = new SuperAdmin();
            $mdp = $this->encoder->encodePassword($marvie, 'password');
            $marvie->setNom("Marvie")
                    ->setPrenom("Baptiste")
                    ->setEmail("bmarvie@gmail.com")
                    ->setMotDePasse($mdp);

            $moussaoui = new SuperAdmin();
            $mdp = $this->encoder->encodePassword($moussaoui, 'password');
            $moussaoui->setNom("Moussaoui")
                            ->setPrenom("Khalil")
                            ->setEmail("khalil_moussaoui_11@ymail.fr")
                            ->setMotDePasse($mdp);

            $manager->persist($moussaoui);
            $manager->persist($marvie);

        $manager->flush();

        }
    }