<?php
namespace Tests\BooksSearchBundle\Repository;

use BooksSearchBundle\Entity\Book;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Bundle\FrameworkBundle\Console\Application;

/**
 * Generated by PHPUnit_SkeletonGenerator on 2017-10-31 at 22:00:10.
 */
class BookRepositoryTest extends KernelTestCase
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $em;
    
    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $kernel = self::bootKernel();
        
        $this->em = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
    }

    /**
     * @covers BooksSearchBundle\Repository\BookRepository::findDefault
     */
    public function testFindDefault()
    {
        // get real count from DB
        $conn = $this->em->getConnection();
        $stmt = $conn->prepare("select count(*) as cnt from book;");
        $stmt->execute();
        $results = $stmt->fetchAll();

        $books = $this->em
            ->getRepository(Book::class)
            ->findDefault()
            ->getResult()
        ;
        
        $this->assertCount((int)$results[0]['cnt'], $books);
    }

    /**
     * @covers BooksSearchBundle\Repository\BookRepository::findByTitleOrAuthor
     */
    public function testFindByTitleOrAuthor()
    {
        // author exists
        $books = $this->em
            ->getRepository(Book::class)
            ->findByTitleOrAuthor('rinpoche')
            ->getResult()
        ;
        $this->assertCount(4, $books);
        
        // title exist
        $books = $this->em
            ->getRepository(Book::class)
            ->findByTitle('Yoga of Offering Food')
            ->getResult()
        ;
        $this->assertCount(1, $books);
        
        // search term do not exists in DB
        $books = $this->em
            ->getRepository(Book::class)
            ->findByTitle('Yoga of Offering Food No Existing Search Term')
            ->getResult()
        ;
        $this->assertCount(0, $books);
    }

    /**
     * @covers BooksSearchBundle\Repository\BookRepository::findByTitle
     */
    public function testFindByTitle()
    {
        // existing title
        $books = $this->em
            ->getRepository(Book::class)
            ->findByTitle('Yoga of Offering Food')
            ->getResult()
        ;
        $this->assertCount(1, $books);
        
        // non existing title
        $books = $this->em
            ->getRepository(Book::class)
            ->findByTitle('Some title you will never ever find in this library')
            ->getResult()
        ;
        $this->assertCount(0, $books);
    }

    /**
     * @covers BooksSearchBundle\Repository\BookRepository::findByAuthor
     */
    public function testFindByAuthor()
    {
        //existing author
        $books = $this->em
            ->getRepository(Book::class)
            ->findByAuthor('rinpoche')
            ->getResult()
        ;
        $this->assertCount(3, $books);
        
        // non existing author
        $books = $this->em
            ->getRepository(Book::class)
            ->findByTitle('Some author you will never ever find in this library')
            ->getResult()
        ;
        $this->assertCount(0, $books);
    }
}
