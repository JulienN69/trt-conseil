<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Recruiter;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class RecruiterFixtures extends Fixture implements DependentFixtureInterface
{

    public function load(ObjectManager $manager): void
    {

        $faker = Factory::create('fr_FR');

        for ($i = 1; $i < 11; $i++) {

            if($i % 2 === 0) {

                $newRecruiter = new Recruiter();
                $newRecruiter->setUser($this->getReference('recruiter-'. $i));
                $newRecruiter->setCompagnyName($faker->company());
                $newRecruiter->setAdress($faker->address());
                $newRecruiter->setIsValid(true);
    
                $manager->persist($newRecruiter);
                $this->addReference('recruiterUser-' . $i, $newRecruiter);

            }        

        }

        $manager->flush();

    }

    public function getDependencies()
    {
        return [
            UserFixtures::class,
        ];
    }
}