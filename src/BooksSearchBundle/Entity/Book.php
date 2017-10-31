<?php

namespace BooksSearchBundle\Entity;

use Symfony\Component\Serializer\Annotation\Groups;

/**
 * Book
 */
class Book
{
    /**
     * @Groups({"book_view"})
     * @var integer
     */
    private $id;

    /**
     * @Groups({"book_view"})
     * @var string
     */
    private $gid;

    /**
     * @Groups({"book_view"})
     * @var string
     */
    private $etag;

    /**
     * @Groups({"book_view"})
     * @var string
     */
    private $selfLink;


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
     * Set gid
     *
     * @param string $gid
     *
     * @return Book
     */
    public function setGid($gid)
    {
        $this->gid = $gid;

        return $this;
    }

    /**
     * Get gid
     *
     * @return string
     */
    public function getGid()
    {
        return $this->gid;
    }

    /**
     * Set etag
     *
     * @param string $etag
     *
     * @return Book
     */
    public function setEtag($etag)
    {
        $this->etag = $etag;

        return $this;
    }

    /**
     * Get etag
     *
     * @return string
     */
    public function getEtag()
    {
        return $this->etag;
    }

    /**
     * Set selfLink
     *
     * @param string $selfLink
     *
     * @return Book
     */
    public function setSelfLink($selfLink)
    {
        $this->selfLink = $selfLink;

        return $this;
    }

    /**
     * Get selfLink
     *
     * @return string
     */
    public function getSelfLink()
    {
        return $this->selfLink;
    }
    /**
     * @Groups({"book_view"})
     * @var \BooksSearchBundle\Entity\VolumeInfo
     */
    private $volumeInfo;


    /**
     * Set volumeInfo
     *
     * @param \BooksSearchBundle\Entity\VolumeInfo $volumeInfo
     *
     * @return Book
     */
    public function setVolumeInfo(\BooksSearchBundle\Entity\VolumeInfo $volumeInfo = null)
    {
        $this->volumeInfo = $volumeInfo;

        return $this;
    }

    /**
     * Get volumeInfo
     *
     * @return \BooksSearchBundle\Entity\VolumeInfo
     */
    public function getVolumeInfo()
    {
        return $this->volumeInfo;
    }
    /**
     * @Groups({"book_view"})
     * @var \BooksSearchBundle\Entity\SearchInfo
     */
    private $searchInfo;


    /**
     * Set searchInfo
     *
     * @param \BooksSearchBundle\Entity\SearchInfo $searchInfo
     *
     * @return Book
     */
    public function setSearchInfo(\BooksSearchBundle\Entity\SearchInfo $searchInfo = null)
    {
        $this->searchInfo = $searchInfo;

        return $this;
    }

    /**
     * Get searchInfo
     *
     * @return \BooksSearchBundle\Entity\SearchInfo
     */
    public function getSearchInfo()
    {
        return $this->searchInfo;
    }
}
