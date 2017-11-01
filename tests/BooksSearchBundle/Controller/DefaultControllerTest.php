<?php

namespace BooksSearchBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    /**
     * @covers BooksSearchBundle\Controller\DefaultController::indexAction
     */
    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/');
        
        $this->assertEquals(200, $client->getResponse()->getStatusCode(), "Correct responce code");
        $this->assertContains('Search for book', $client->getResponse()->getContent());
    }
    
    public function testSearch()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/search');
        $this->assertTrue($client->getResponse()->isRedirect(),'Submit ok');
        $this->assertEquals(302, $client->getResponse()->getStatusCode(), "Correct redirect to page ok");

        $client->followRedirect();
        $this->assertContains('Search for book', $client->getResponse()->getContent());
    }
    
    public function testBook()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/book/1');

        $this->assertContains('ltKw2ApTXls', $client->getResponse()->getContent());
    }
}
