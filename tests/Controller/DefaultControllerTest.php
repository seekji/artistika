<?php

namespace App\Tests\Controller;

use App\DataFixtures\ORM\LoadCityDataFixture;
use Liip\FunctionalTestBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    protected static $wasSetup = false;

    protected function setUp()
    {
        parent::setUp();

        if (false === static::$wasSetup) {
            $this->loadFixtures([
                LoadCityDataFixture::class,
            ]);

            static::$wasSetup = true;
        }
    }

    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
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
