<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class MainControllerTest extends WebTestCase
{
    public function testSomething(): void
    {
        $client = static::createClient();

        // Option 1 with symfony custom asserts
        $client->request('GET', '/');
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h4', 'wide selection of the newer movies');

        // OR Option 2 with crawler
        $crawler = $client->request('GET', '/');
        $this->assertStringContainsString('wide selection', $crawler->filter('h4')->text());
    }

    public function testMovieDetail(): void
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/movie/1');
        $this->assertStringContainsString('Memento', $crawler->filter('h1')->text());
        $crawler = $client->request('GET', '/movie/2');
        $this->assertStringContainsString('Insomnia', $crawler->filter('h1')->text());
    }
}
