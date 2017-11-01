<?php

namespace BooksSearchBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use BooksSearchBundle\Entity\Book;

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
        
        $em = $client->getContainer()->get('doctrine.orm.entity_manager');
        $db_book = $em->getRepository(Book::class)->find(1);
        
        $crawler = $client->request('GET', '/book/1');
        $response = $client->getResponse();
        $this->assertEquals(200, $response->getStatusCode(), "Correct redirect to page ok");
        
        $this->assertTrue($response->headers->contains('Content-Type', 'application/json'));

        $this->assertJson($response->getContent());
        $responseData = json_decode($response->getContent(), true);

        $book = $responseData[0];

        $this->assertEquals($db_book->getEtag(), $book['etag']);
        $this->assertEquals($db_book->getGid(), $book['gid']);
        $this->assertEquals($db_book->getSelfLink(), $book['selfLink']);
        
        $this->assertArrayHasKey('volumeInfo', $book);
        $this->assertInternalType('array', $book['volumeInfo']);
        
        $vi = $db_book->getVolumeInfo();
        $this->assertEquals($vi->getTitle(), $book['volumeInfo']['title']);
        $this->assertEquals($vi->getPublishedDate(), $book['volumeInfo']['publishedDate']);
        $this->assertEquals($vi->getDescription(), $book['volumeInfo']['description']);
        $this->assertEquals($vi->getPageCount(), $book['volumeInfo']['pageCount']);
        $this->assertEquals($vi->getLanguage(), $book['volumeInfo']['language']);
        $this->assertEquals($vi->getPreviewLink(), $book['volumeInfo']['previewLink']);
        $this->assertEquals($vi->getInfoLink(), $book['volumeInfo']['infoLink']);
        
        $this->assertArrayHasKey('imageLinks', $book['volumeInfo']);
        if (is_array($book['volumeInfo']['imageLinks'])) {
            $db_imageLinks = $vi->getImageLinks();
            $this->assertEquals($book['volumeInfo']['imageLinks']['smallThumbnail'], $db_imageLinks->getSmallThumbnail());
            $this->assertEquals($book['volumeInfo']['imageLinks']['thumbnail'], $db_imageLinks->getThumbnail());
        }

        $this->assertArrayHasKey('publisher', $book['volumeInfo']);
        if (is_array($book['volumeInfo']['publisher'])) {
            $db_publisher = $vi->getPublisher();
            $this->assertEquals($book['volumeInfo']['publisher']['name'], $db_publisher->getName());
        }

        $this->assertArrayHasKey('authors', $book['volumeInfo']);
        $this->assertInternalType('array', $book['volumeInfo']['authors']);

        $this->assertArrayHasKey('categories', $book['volumeInfo']);
        $this->assertInternalType('array', $book['volumeInfo']['categories']);

        $this->assertArrayHasKey('searchInfo', $book);
        $this->assertInternalType('array', $book['searchInfo']);
        $this->assertContains(
            $db_book->getSearchInfo()->getTextSnippet(),
            $book['searchInfo']['textSnippet']);
    }
}
