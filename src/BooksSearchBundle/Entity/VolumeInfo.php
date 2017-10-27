<?php

namespace BooksSearchBundle\Entity;

/**
 * VolumeInfo
 */
class VolumeInfo
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $publishedDate;

    /**
     * @var string
     */
    private $description;

    /**
     * @var integer
     */
    private $pageCount;

    /**
     * @var string
     */
    private $language;

    /**
     * @var string
     */
    private $previewLink;

    /**
     * @var string
     */
    private $infoLink;

    /**
     * @var \BooksSearchBundle\Entity\Book
     */
    private $book;

    /**
     * @var \BooksSearchBundle\Entity\ImageLink
     */
    private $imageLinks;

    /**
     * @var \BooksSearchBundle\Entity\Publisher
     */
    private $publisher;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $authors;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $categories;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->authors = new \Doctrine\Common\Collections\ArrayCollection();
        $this->categories = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return VolumeInfo
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set publishedDate
     *
     * @param string $publishedDate
     *
     * @return VolumeInfo
     */
    public function setPublishedDate($publishedDate)
    {
        $this->publishedDate = $publishedDate;

        return $this;
    }

    /**
     * Get publishedDate
     *
     * @return string
     */
    public function getPublishedDate()
    {
        return $this->publishedDate;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return VolumeInfo
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set pageCount
     *
     * @param integer $pageCount
     *
     * @return VolumeInfo
     */
    public function setPageCount($pageCount)
    {
        $this->pageCount = $pageCount;

        return $this;
    }

    /**
     * Get pageCount
     *
     * @return integer
     */
    public function getPageCount()
    {
        return $this->pageCount;
    }

    /**
     * Set language
     *
     * @param string $language
     *
     * @return VolumeInfo
     */
    public function setLanguage($language)
    {
        $this->language = $language;

        return $this;
    }

    /**
     * Get language
     *
     * @return string
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * Set previewLink
     *
     * @param string $previewLink
     *
     * @return VolumeInfo
     */
    public function setPreviewLink($previewLink)
    {
        $this->previewLink = $previewLink;

        return $this;
    }

    /**
     * Get previewLink
     *
     * @return string
     */
    public function getPreviewLink()
    {
        return $this->previewLink;
    }

    /**
     * Set infoLink
     *
     * @param string $infoLink
     *
     * @return VolumeInfo
     */
    public function setInfoLink($infoLink)
    {
        $this->infoLink = $infoLink;

        return $this;
    }

    /**
     * Get infoLink
     *
     * @return string
     */
    public function getInfoLink()
    {
        return $this->infoLink;
    }

    /**
     * Set book
     *
     * @param \BooksSearchBundle\Entity\Book $book
     *
     * @return VolumeInfo
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

    /**
     * Set imageLinks
     *
     * @param \BooksSearchBundle\Entity\ImageLink $imageLinks
     *
     * @return VolumeInfo
     */
    public function setImageLinks(\BooksSearchBundle\Entity\ImageLink $imageLinks = null)
    {
        $this->imageLinks = $imageLinks;

        return $this;
    }

    /**
     * Get imageLinks
     *
     * @return \BooksSearchBundle\Entity\ImageLink
     */
    public function getImageLinks()
    {
        return $this->imageLinks;
    }

    /**
     * Set publisher
     *
     * @param \BooksSearchBundle\Entity\Publisher $publisher
     *
     * @return VolumeInfo
     */
    public function setPublisher(\BooksSearchBundle\Entity\Publisher $publisher = null)
    {
        $this->publisher = $publisher;

        return $this;
    }

    /**
     * Get publisher
     *
     * @return \BooksSearchBundle\Entity\Publisher
     */
    public function getPublisher()
    {
        return $this->publisher;
    }

    /**
     * Add author
     *
     * @param \BooksSearchBundle\Entity\Author $author
     *
     * @return VolumeInfo
     */
    public function addAuthor(\BooksSearchBundle\Entity\Author $author)
    {
        $this->authors[] = $author;

        return $this;
    }

    /**
     * Remove author
     *
     * @param \BooksSearchBundle\Entity\Author $author
     */
    public function removeAuthor(\BooksSearchBundle\Entity\Author $author)
    {
        $this->authors->removeElement($author);
    }

    /**
     * Get authors
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAuthors()
    {
        return $this->authors;
    }

    /**
     * Add category
     *
     * @param \BooksSearchBundle\Entity\Category $category
     *
     * @return VolumeInfo
     */
    public function addCategory(\BooksSearchBundle\Entity\Category $category)
    {
        $this->categories[] = $category;

        return $this;
    }

    /**
     * Remove category
     *
     * @param \BooksSearchBundle\Entity\Category $category
     */
    public function removeCategory(\BooksSearchBundle\Entity\Category $category)
    {
        $this->categories->removeElement($category);
    }

    /**
     * Get categories
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCategories()
    {
        return $this->categories;
    }
}

