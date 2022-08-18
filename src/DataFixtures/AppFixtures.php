<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\User;
use App\Entity\Partner;
use App\Entity\Structure;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    public function __construct(
        UserPasswordHasherInterface $passwordHasher,
        SluggerInterface $slugger)
    {
        $this->passwordHasher = $passwordHasher;
        $this->slugger = $slugger;
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

         //NEW USER
         $adminUser = new User();
         $orangeUser1 = new User();
         $orangePartner1 = new Partner();
         $orangeUser2 = new User();
         $orangeUser3 = new User();
         $orangeStructure1 = new Structure();
         $orangeStructure2 = new Structure();

         //ADMIN
         $adminUser->setName('Nicolas Barthès');
         $adminUser->setEmail('admin@admin.fr');
         $adminUser->setRoles(['ROLE_ADMIN']);
         $adminUser->setPassword($this->passwordHasher->hashPassword($adminUser, ('admin')));
 
         // USER 1
         $orangeUser1
             ->setEmail('orangebleuedunkerque@direction.fr')
             ->setPassword('dunkerque')
             ->setName('Directeur Orange Bleue Dunkerque')
             ->setRoles(['ROLE_PARTENAIRE'])
             ;
        
         //USER 2
        $orangeUser2
            ->setEmail('ruetartuffe@orangebleue.fr')
            ->setPassword('Tartuffe')
            ->setName('Club Structure rue tartuffe DUNKERQUE')
            ->setRoles(['ROLE_STRUCTURE'])
            ;
        
        $orangeUser3
            ->setEmail('ruemontmartre@orangebleue.fr')
            ->setPassword('Montmartre')
            ->setName('Club Structure rue Montmartre DUNKERQUE')
            ->setRoles(['ROLE_STRUCTURE'])
            ;


          // PARTNER 1 (rattaché à User 1)
         $orangePartner1
             ->setName('L\'orange Bleue Dunkerque (Partner 1)')
             ->setUser($orangeUser1)
             ->setIsPlanning(1)
             ->setIsNewsletter(0)
             ->setIsBoissons(1)
             ->setIsSms(0)
             ->setIsConcours(1)
             ->addStructure($orangeStructure1);

         // STRUCTURE 1 (rattaché à User 2)
        $orangeStructure1
            ->setUser($orangeUser2)
            ->setPartner($orangePartner1)
            ->setPostalAdress('3 rue tartuffe, Dunkerque (Structure 1)')
            ->setIsPlanning($orangePartner1->isIsPlanning())
            ->setIsNewsletter($orangePartner1->isIsNewsletter())
            ->setIsBoissons($orangePartner1->isIsBoissons())
            ->setIsSms($orangePartner1->isIsSms())
            ->setIsConcours($orangePartner1->isIsConcours())
            ;

        $orangeStructure2
            ->setUser($orangeUser3)
            ->setPartner($orangePartner1)
            ->setPostalAdress('15 rue Montmartre, Dunkerque (Structure 2)')
            ->setIsPlanning($orangePartner1->isIsPlanning())
            ->setIsNewsletter($orangePartner1->isIsNewsletter())
            ->setIsBoissons($orangePartner1->isIsBoissons())
            ->setIsSms($orangePartner1->isIsSms())
            ->setIsConcours($orangePartner1->isIsConcours());

        // Commits
         $manager->persist($adminUser);
         $manager->persist($orangeUser1);
         $manager->persist($orangeUser2);
         $manager->persist($orangePartner1);
         $manager->persist($orangeStructure1);
         $manager->persist($orangeStructure2);

        // Push
        $manager->flush();
    }
}
