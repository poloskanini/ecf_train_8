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
 
         $orangeUser1
             ->setEmail('orangebleuedunkerque@direction.fr')
             ->setPassword('dunkerque')
             ->setName('Directeur Orange Bleue Dunkerque')
             ->setRoles(['ROLE_PARTENAIRE'])
             ;
        
        $orangeUser2 = new User();
        $orangeUser2
            ->setEmail('ruetartuffe@orangebleue.fr')
            ->setPassword('Tartuffe')
            ->setName('Gérant Structure rue tartuffe DUNKERQUE')
            ->setRoles(['ROLE_STRUCTURE'])
            ;

         $orangePartner1
             ->setName('L\'orange Bleue Dunkerque')
             ->setUser($orangeUser1)
             ->setPermissions([
                 ['planning' => '1'],
                 ['newsletter' => '1'],
                 ['boissons' => '1'],
                 ['sms' => '1'],
                 ['concours' => '1'],
             ])
             ;
        $orangeStructure1
            ->setUser($orangeUser2)
            ->setPartner($orangePartner1)
            ->setPostalAdress('3 rue tartuffe, Dunkerque')
            ;
        
         $manager->persist($orangeUser1);
         $manager->persist($orangeUser2);
         $manager->persist($orangePartner1);
         $manager->persist($orangeStructure1);

        $manager->flush();
    }
}