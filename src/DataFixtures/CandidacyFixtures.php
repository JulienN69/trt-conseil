<?php

namespace App\DataFixtures;

use App\Entity\Candidacy;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class CandidacyFixtures extends Fixture implements DependentFixtureInterface
{

    public function load(ObjectManager $manager): void
    {     
        $e = [];
        for ($i = 0; $i < 20; $i++){
            $e[] = $i;
        }

        for ($i = 0; $i < 10; $i++) {

            $u = [1, 3, 5, 7, 9];
            $recruiterIndex = array_rand($u);
            $recruiterId = $u[$recruiterIndex];

            $candidacy = new Candidacy();
            $candidacy->setCandidate($this->getReference('candidateUser-' . $recruiterId));
            $candidacy->setAnnouncement($this->getReference('announcement-' . array_rand($e)));
            $candidacy->setIsValid(true);

            $manager->persist($candidacy);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            CandidateFixtures::class,
            AnnouncementFixtures::class
        ];
    }
}