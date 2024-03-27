<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Announcement;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class AnnouncementFixtures extends Fixture implements DependentFixtureInterface
{

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        for ($i = 0; $i < 20; $i++){  
                    
            $u = [2, 4, 6, 8, 10];
            $recruiterIndex = array_rand($u);
            $recruiterId = $u[$recruiterIndex];

            $announcement = new Announcement();
            $announcement->setRecruiter($this->getReference('recruiterUser-'. $recruiterId));
            $announcement->setJobTitle($faker->jobTitle());
            $announcement->setDescription($faker->text(60));
            $announcement->setWorkPlace($faker->address());
            $announcement->setIsValid(true);
            $manager->persist($announcement);
            $this->addReference('announcement-' . $i, $announcement);           
        }  
        $manager->flush();
    }
    public function getDependencies()
    {
        return [
            RecruiterFixtures::class,
        ];
    }
}