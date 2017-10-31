<?php

namespace BooksSearchBundle\Entity;

use Symfony\Component\Serializer\Annotation\Groups;

/**
 * Author
 */
class Author
{
    /**
     * @var int
     */
    private $id;

    /**
     * @Groups({"book_view"})
     * @var string
     */
    private $name;


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
     * Set name
     *
     * @param string $name
     *
     * @return Author
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $itemRecords;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->itemRecords = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add itemRecord
     *
     * @param \BooksSearchBundle\Entity\VolumeInfo $itemRecord
     *
     * @return Author
     */
    public function addItemRecord(\BooksSearchBundle\Entity\VolumeInfo $itemRecord)
    {
        $this->itemRecords[] = $itemRecord;

        return $this;
    }

    /**
     * Remove itemRecord
     *
     * @param \BooksSearchBundle\Entity\VolumeInfo $itemRecord
     */
    public function removeItemRecord(\BooksSearchBundle\Entity\VolumeInfo $itemRecord)
    {
        $this->itemRecords->removeElement($itemRecord);
    }

    /**
     * Get itemRecords
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getItemRecords()
    {
        return $this->itemRecords;
    }
}
