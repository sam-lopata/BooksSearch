<?php

namespace BooksSearchBundle\Entity;

/**
 * ImageLink
 */
class ImageLink
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $smallThumbnail;

    /**
     * @var string
     */
    private $thumbnail;

    /**
     * @var \BooksSearchBundle\Entity\VolumeInfo
     */
    private $volume;


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
     * Set smallThumbnail
     *
     * @param string $smallThumbnail
     *
     * @return ImageLink
     */
    public function setSmallThumbnail($smallThumbnail)
    {
        $this->smallThumbnail = $smallThumbnail;

        return $this;
    }

    /**
     * Get smallThumbnail
     *
     * @return string
     */
    public function getSmallThumbnail()
    {
        return $this->smallThumbnail;
    }

    /**
     * Set thumbnail
     *
     * @param string $thumbnail
     *
     * @return ImageLink
     */
    public function setThumbnail($thumbnail)
    {
        $this->thumbnail = $thumbnail;

        return $this;
    }

    /**
     * Get thumbnail
     *
     * @return string
     */
    public function getThumbnail()
    {
        return $this->thumbnail;
    }

    /**
     * Set volume
     *
     * @param \BooksSearchBundle\Entity\VolumeInfo $volume
     *
     * @return ImageLink
     */
    public function setVolume(\BooksSearchBundle\Entity\VolumeInfo $volume = null)
    {
        $this->volume = $volume;

        return $this;
    }

    /**
     * Get volume
     *
     * @return \BooksSearchBundle\Entity\VolumeInfo
     */
    public function getVolume()
    {
        return $this->volume;
    }
}

