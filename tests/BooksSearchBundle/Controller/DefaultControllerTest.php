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

        $this->assertCount(9, $crawler->filter('a[href*=book]'));
        $this->assertCount(1, $crawler->filter('input[id=key]'));

        $this->assertCount(1, $crawler->filter('input[type=radio][value=everywhere]'));
        $this->assertCount(1, $crawler->filter('input[type=radio][value=title]'));
        $this->assertCount(1, $crawler->filter('input[type=radio][value=author]'));
        $this->assertCount(1, $crawler->filter('button[type=submit]'));

        $this->assertCount(1, $crawler->filter('ul[class=pagination]'));
    }
    
    /**
     * @covers BooksSearchBundle\Controller\DefaultController::searchAction
     */
    public function testSearch()
    {
        $client = static::createClient();

        // redirects to root with no search term
        $crawler = $client->request('GET', '/search');
        $this->assertTrue($client->getResponse()->isRedirect(),'Submit ok');
        $this->assertEquals(302, $client->getResponse()->getStatusCode(), "Correct redirect to page ok");
        $client->followRedirect();
        $this->assertContains('Search for book', $client->getResponse()->getContent());

        // Nothing found
        $crawler = $client->request('GET', '/');
        $form = $crawler->selectButton('search')->form();
        $form['key'] = 'Rinpochete';
        $form['where'] = 'everywhere';
        $crawler = $client->submit($form);
        $this->assertContains('<h3>Nothing found.</h3>', $client->getResponse()->getContent());

        // Something found everywhere
        $crawler = $client->request('GET', '/');
        $form = $crawler->selectButton('search')->form();
        $form['key'] = 'Rinpoche';
        $form['where'] = 'everywhere';
        $crawler = $client->submit($form);
        $this->assertCount(4, $crawler->filter('a[href*=book]'));

        // Something found in title
        $crawler = $client->request('GET', '/');
        $form = $crawler->selectButton('search')->form();
        $form['key'] = 'Rinpoche';
        $form['where'] = 'title';
        $crawler = $client->submit($form);
        $this->assertCount(1, $crawler->filter('a[href*=book]'));

        // Something found in author
        $crawler = $client->request('GET', '/');
        $form = $crawler->selectButton('search')->form();
        $form['key'] = 'Rinpoche';
        $form['where'] = 'author';
        $crawler = $client->submit($form);
        $this->assertCount(3, $crawler->filter('a[href*=book]'));


    }
    
    /**
     * @covers BooksSearchBundle\Controller\DefaultController::bookAction
     */
    public function testBook()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/book/1');
        $response = $client->getResponse();
        $this->assertEquals(200, $response->getStatusCode(), "Correct redirect to page ok");
        
        $this->assertTrue($response->headers->contains('Content-Type', 'application/json'));

        $this->assertJson($response->getContent());
        $responseData = json_decode($response->getContent(), true);

        $book = $responseData[0];
        // var_dump($responseData);

        $this->assertEquals('LhWsHoVLRUg',$book['etag']);
        $this->assertEquals('JMYulwEACAAJ',$book['gid']);
        $this->assertArrayHasKey('volumeInfo', $book);
        $this->assertInternalType('array', $book['volumeInfo']);
        $this->assertEquals('The Best of Philip K. Dick',$book['volumeInfo']['title']);
        $this->assertArrayHasKey('imageLinks', $book['volumeInfo']);
        $this->assertInternalType('array', $book['volumeInfo']['imageLinks']);

        $this->assertArrayHasKey('publisher', $book['volumeInfo']);
        $this->assertNull($book['volumeInfo']['publisher']);

        $this->assertArrayHasKey('authors', $book['volumeInfo']);
        $this->assertInternalType('array', $book['volumeInfo']['authors']);

        $this->assertArrayHasKey('categories', $book['volumeInfo']);
        $this->assertInternalType('array', $book['volumeInfo']['categories']);

        $this->assertArrayHasKey('searchInfo', $book);
        $this->assertInternalType('array', $book['searchInfo']);
        $this->assertContains(
            'Collected here are thirteen of his most Dickian tales, funhouse realities with trap doors and hidden compartments',
            $book['searchInfo']['textSnippet']);
    }
}
