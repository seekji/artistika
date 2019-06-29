<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertContains('Welcome to Symfony', $crawler->filter('#container h1')->text());
    }

    public function testApiDocIndex()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/api/doc');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertContains('API documentation', $crawler->filter('#header h1')->text());
    }

    public function test404()
    {
        $client = static::createClient();

        $client->request('GET', sprintf('/%s', uniqid()));

        $this->assertTrue($client->getResponse()->isNotFound());
    }

}
