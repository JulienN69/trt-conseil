<?php

namespace App\tests\Controller;

use App\Repository\UserRepository;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SmokeTest extends WebTestCase
{
    /**
     * @dataProvider urlProvider
     */
    public function testPageIsSuccessful($url): void
    {
        $client = self::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);
        
        $testUser = $userRepository->findOneByEmail('recruiter2@gmail.com');

        $client->loginUser($testUser);

        $client->request('GET', $url);

        $this->assertResponseIsSuccessful();
    }

    public function urlProvider(): \Generator
    {
        yield ['/'];
        yield ['/announcement'];
        yield ['/candidacy'];
        yield ['/register'];
        yield ['/login'];
        yield ['/recruiter/6'];
        
    }
}
