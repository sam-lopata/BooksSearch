<?php

namespace BooksSearchBundle\Entity;

use Symfony\Component\Serializer\Annotation\Groups;

/**
 * Publisher
 */
class Publisher
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
     * @return Publisher
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
}
