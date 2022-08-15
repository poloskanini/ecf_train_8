<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Partner;
use App\Entity\Structure;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
         //NEW USER
         $orangeUser1 = new User();
         $orangePartner1 = new Partner();
         $orangeUser2 = new User();
         $orangeStructure1 = new Structure();
 
         // USER 1
         $orangeUser1
             ->setEmail('orangebleuedunkerque@direction.fr')
             ->setPassword('dunkerque')
             ->setName('Directeur Orange Bleue Dunkerque')
             ->setRoles(['ROLE_PARTENAIRE'])
             ;
        
         //USER 2
        $orangeUser2 = new User();
        $orangeUser2
            ->setEmail('ruetartuffe@orangebleue.fr')
            ->setPassword('Tartuffe')
            ->setName('Gérant Structure rue tartuffe DUNKERQUE')
            ->setRoles(['ROLE_STRUCTURE'])
            ;

          // PARTNER 1 (rattaché à User 1)
         $orangePartner1
             ->setName('L\'orange Bleue Dunkerque')
             ->setUser($orangeUser1)
             ->setIsPlanning(1)
             ->setIsNewsletter(1)
             ->setIsBoissons(1)
             ->setIsSms(1)
             ->setIsConcours(1)
             ;

         // STRUCTURE 1 (rattaché à User 2)
        $orangeStructure1
            ->setUser($orangeUser2)
            ->setPartner($orangePartner1)
            ->setPostalAdress('3 rue tartuffe, Dunkerque')
            ->setIsPlanning(0)
            ->setIsNewsletter(0)
            ->setIsBoissons(0)
            ->setIsSms(0)
            ->setIsConcours(0)
            ;
        
         $manager->persist($orangeUser1);
         $manager->persist($orangeUser2);
         $manager->persist($orangePartner1);
         $manager->persist($orangeStructure1);

        $manager->flush();
    }
}
