<?php

namespace WW\Gastro\ApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * RoomTable
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class RoomTable
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var Place[]
     *
     * @ORM\OneToMany(targetEntity="Place", mappedBy="roomtable")
     */
    protected $places;

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
     * Set name
     *
     * @param string $name
     *
     * @return RoomTable
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
     * Constructor
     */
    public function __construct()
    {
        $this->places = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add place
     *
     * @param \WW\Gastro\ApiBundle\Entity\Place $place
     *
     * @return RoomTable
     */
    public function addPlace(\WW\Gastro\ApiBundle\Entity\Place $place)
    {
        $this->places[] = $place;

        return $this;
    }

    /**
     * Remove place
     *
     * @param \WW\Gastro\ApiBundle\Entity\Place $place
     */
    public function removePlace(\WW\Gastro\ApiBundle\Entity\Place $place)
    {
        $this->places->removeElement($place);
    }

    /**
     * Get places
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPlaces()
    {
        return $this->places;
    }
}
