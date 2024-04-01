<?php

namespace App\Tests\Entity;

use App\Entity\Announcement;
use App\Entity\Recruiter;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class EntityTest extends KernelTestCase
{
    public function testEntityAnnouncementIsValid(): void
    {
        self::bootKernel();
        $container = static::getContainer();
        $recruiter = new Recruiter;

        $announcement = new Announcement;
        $announcement->setDescription('ceci est un test')
                    ->setIsValid(true)
                    ->setJobTitle('facteur')
                    ->setRecruiter($recruiter);

        $errors = $container->get('validator')->validate($announcement);

        $this->assertCount(0, $errors);

    }
}
