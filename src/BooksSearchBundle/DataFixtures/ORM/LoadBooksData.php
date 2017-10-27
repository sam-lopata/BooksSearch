<?php

// src/BooksSearchBundle/DataFixtures/ORM/Fixtures.php
namespace BooksSearchBundle\DataFixtures\ORM;

use BooksSearchBundle\Entity\Book;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use BooksSearchBundle\Repository\CategoryRepository;


class LoadBooksData extends Fixture
{
    private $totalItems;
    
    public function load(ObjectManager $manager)
    {        
        $buzz = $this->container->get('buzz');
        
        $queries = array('Stephen+King', 'Rinpochete', "Jazz", "PHP");
        foreach ($queries as $query) {
            $response = $buzz->get('https://www.googleapis.com/books/v1/volumes?q=' . $query);
            $books_fixtures = json_decode($response->getContent());
            
            foreach ($books_fixtures->items as $fixture) {
                $this->addFixture($fixture, $manager);
                $this->totalItems++;
            }
        }
        echo "Items imported: " . $this->totalItems .PHP_EOL;
    }
    
    private function addFixture($fixture, &$manager)
    {
        $book = new Book();
        $book->setGid($fixture->id);
        $book->setEtag($fixture->etag);
        $book->setSelfLink($fixture->selfLink);
        if (isset($fixture->searchInfo->textSnippet)) {
            $searchInfo = new \BooksSearchBundle\Entity\SearchInfo();
            $searchInfo->setTextSnippet($fixture->searchInfo->textSnippet);
            $book->setSearchInfo($searchInfo);
        }
        $volumeInfo = new \BooksSearchBundle\Entity\VolumeInfo();
        $volumeInfo
                ->setTitle($fixture->volumeInfo->title)
                ->setPublishedDate($fixture->volumeInfo->publishedDate)
                ->setDescription($fixture->volumeInfo->description ?? "")
                ->setPageCount($fixture->volumeInfo->pageCount ?? 0)
                ->setLanguage($fixture->volumeInfo->language)
                ->setPreviewLink($fixture->volumeInfo->previewLink)
                ->setInfoLink($fixture->volumeInfo->infoLink);
        
        if (isset($fixture->volumeInfo->categories)) {
            foreach ($fixture->volumeInfo->categories as $fcategory) {
                $existed_category = $manager->getRepository('BooksSearchBundle:Category')->findOneBy(array('name' => $fcategory));
                if ($existed_category && $existed_category->getName() == $fcategory) {
                    $volumeInfo->addCategory($existed_category);
                }
                else {
                    $category = new \BooksSearchBundle\Entity\Category();
                    $category->setName($fcategory);
                    $volumeInfo->addCategory($category);
                }
            }
        }
                             
        if (isset($fixture->volumeInfo->authors)) {
            foreach ($fixture->volumeInfo->authors as $fauthor) {
                $existed_author = $manager->getRepository('BooksSearchBundle:Author')->findOneBy(array('name' => $fauthor));
                if ($existed_author && $existed_author->getName() == $fauthor) {
                    $volumeInfo->addAuthor($existed_author);
                }
                else {
                    $author = new \BooksSearchBundle\Entity\Author();
                    $author->setName($fauthor);
                    $volumeInfo->addAuthor($author);
                }      
            } 
        }
        
        if (isset($fixture->volumeInfo->publisher)) {
            $fpublisher = $fixture->volumeInfo->publisher;
            $existed_publisher = $manager->getRepository('BooksSearchBundle:Publisher')->findOneBy(array('name' => $fpublisher));
            if ($existed_publisher && $existed_publisher->getName() == $fpublisher) {
                $volumeInfo->setPublisher($existed_publisher);
            }
            else {
                $publisher = new \BooksSearchBundle\Entity\Publisher();
                $publisher->setName($fpublisher);
                $volumeInfo->setPublisher($publisher);
            }
        }
        
        if (isset($fixture->volumeInfo->imageLinks)) {
            $imageLinks = new \BooksSearchBundle\Entity\ImageLink();
            $imageLinks
                    ->setThumbnail($fixture->volumeInfo->imageLinks->thumbnail)
                    ->setSmallThumbnail($fixture->volumeInfo->imageLinks->smallThumbnail);
            $volumeInfo->setImageLinks($imageLinks);
        }
        
        
        $book->setVolumeInfo($volumeInfo);
        $manager->persist($book);
        $manager->flush();
    }
}

