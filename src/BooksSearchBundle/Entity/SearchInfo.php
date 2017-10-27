<?php

namespace BooksSearchBundle\Entity;

/**
 * SearchInfo
 */
class SearchInfo
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $textSnippet;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set textSnippet
     *
     * @param string $textSnippet
     *
     * @return SearchInfo
     */
    public function setTextSnippet($textSnippet)
    {
        $this->textSnippet = $textSnippet;

        return $this;
    }

    /**
     * Get textSnippet
     *
     * @return string
     */
    public function getTextSnippet()
    {
        return $this->textSnippet;
    }
    /**
     * @var \BooksSearchBundle\Entity\Book
     */
    private $book;


    /**
     * Set book
     *
     * @param \BooksSearchBundle\Entity\Book $book
     *
     * @return SearchInfo
     */
    public function setBook(\BooksSearchBundle\Entity\Book $book = null)
    {
        $this->book = $book;

        return $this;
    }

    /**
     * Get book
     *
     * @return \BooksSearchBundle\Entity\Book
     */
    public function getBook()
    {
        return $this->book;
    }
}
