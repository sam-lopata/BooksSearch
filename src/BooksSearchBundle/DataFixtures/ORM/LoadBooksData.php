<?php

// src/BooksSearchBundle/DataFixtures/ORM/Fixtures.php
namespace BooksSearchBundle\DataFixtures\ORM;

use BooksSearchBundle\Entity\Book;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class LoadBooksData extends Fixture
{
    private $totalItems;
    
    public function load(ObjectManager $manager)
    {
        $buzz = $this->container->get('buzz');
        
        $statement = $manager->getConnection()->prepare("TRUNCATE TABLE book;");
        $statement->execute();
        
        $authors = array('Stephen+King', 'Rinpochete', 'philip+k.+dick', 'mario+puzo');
        foreach ($authors as $author) {
            $response = $buzz->get('https://www.googleapis.com/books/v1/volumes?q=' . $author);

            $books_fixtures = json_decode($response->getContent());
            
            foreach ($books_fixtures->items as $fixture) {
                $book = new Book();
                $book->setTitle($fixture->volumeInfo->title);
                $book->setPageCount($fixture->volumeInfo->pageCount);
                $book->setDescription($fixture->volumeInfo->description ?? null);
                $book->setPublishedDate(new \DateTime($fixture->volumeInfo->publishedDate ?? null));
                $manager->persist($book);
                $this->totalItems++;
            }
        }
        $manager->flush();
        echo "Items imported: " . $this->totalItems .PHP_EOL;
    }
}

