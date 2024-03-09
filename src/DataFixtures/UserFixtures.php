<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{

    private UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager): void
    {

        for ($i = 1; $i < 11; $i++) {
            $user = new User();
            $userType = $i % 2 === 0 ? 'recruiter' : 'candidate'; 

            $email = sprintf('%s%d@gmail.com', $userType, $i);
            $password = $this->hasher->hashPassword($user, $userType);

            $user->setEmail($email);
            $user->setPassword($password);
            $user->setRoles(['ROLE_USER']);

            $manager->persist($user);
            $this->addReference($userType . '-' . $i, $user);
            
        }

        $manager->flush();

    }
}
