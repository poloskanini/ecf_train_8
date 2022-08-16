<?php

namespace App\DataFixtures;

use Faker;
use App\Entity\User;
use App\Entity\Partner;
use App\Entity\Structure;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


class UserFixtures extends Fixture
{
    public function __construct(UserPasswordHasherInterface $passwordHasher, SluggerInterface $slugger) {
        $this->passwordHasher = $passwordHasher;
        $this->slugger = $slugger;
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create('fr_FR');

        $userAdmin = new User();

        $userAdmin->setName('Nicolas Barthès');
        $userAdmin->setEmail('admin@ecf.fr');
        $userAdmin->setRoles(['ROLE_ADMIN']);
        $userAdmin->setPassword($this->passwordHasher->hashPassword($userAdmin, ('password')));        // ? Convertir un datetime en datetimeImmutable et en se servant d'une méthode FAKER
        // $date = $faker->dateTimeBetween('-1 years', 'now');
        // $immutable = \DateTimeImmutable::createFromMutable( $date );
        // $userAdmin->setCreatedAt($immutable);

        $manager->persist($userAdmin);

        for ($user = 1; $user <= 5; ++$user) {

            // User Creates
            $userGenerate = new User();
            
            $userGenerate->setName($faker->name);
            $email = $userGenerate->getName();
            $userGenerate->setEmail(strtolower($this->slugger->slug($email) .'@ecf.fr'));
            $userGenerate->setRoles(['ROLE_PARTENAIRE']);
            $userGenerate->setPassword($this->passwordHasher->hashPassword($userGenerate, ('password')));

            // Partner Creates
            // $partnerGenerate = new Partner();
            // $partnerGenerate->setName($faker->company);
            // $email = $partnerGenerate->getName();
            // $partnerGenerate->setIsPlanning($faker->boolean(50));
            // $partnerGenerate->setIsNewsletter($faker->boolean(50));
            // $partnerGenerate->setIsBoissons($faker->boolean(50));
            // $partnerGenerate->setIsSms($faker->boolean(50));
            // $partnerGenerate->setIsConcours($faker->boolean(50));

            // User Commit
            $manager->persist($userGenerate);

            // Partner Commit
            // $manager->persist($partnerGenerate);


            $this->addReference(sprintf('user-%d', $user), $userGenerate);
        }

        // Push on DB
        // $manager->flush();
    }

    public static function getGroups(): array
    {
        return ['user'];
    }

}
