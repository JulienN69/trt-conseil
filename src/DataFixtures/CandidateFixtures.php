<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Candidate;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class CandidateFixtures extends Fixture implements DependentFixtureInterface
{

    public function load(ObjectManager $manager): void
    {

        $faker = Factory::create('fr_FR');

        for ($i = 1; $i < 11; $i++) {

            if($i % 2 != 0) {

                $newCandidate = new Candidate();
                $newCandidate->setUser($this->getReference('candidate-'. $i));
                $newCandidate->setLastName($faker->lastName());
                $newCandidate->setFirstName($faker->firstName());
                $newCandidate->setIsValid(true);
    
                $manager->persist($newCandidate);
                $this->addReference('candidateUser-' . $i, $newCandidate);

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