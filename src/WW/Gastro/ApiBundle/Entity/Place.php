<?php

namespace WW\Gastro\ApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Place
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Place
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
     * @ORM\ManyToOne(targetEntity="RoomTable", inversedBy="place")
     * @ORM\JoinColumn(name="roomtable_id", referencedColumnName="id")
     */
    protected $table;

    /**
     * @var boolean
     * @ORM\Column(name="status", type="boolean")
     */
    protected $status = true;

    /**
     * @ORM\ManyToOne(targetEntity="Place", inversedBy="roomtables")
     * @ORM\JoinColumn(name="roomtable_id", referencedColumnName="id")
     */
    protected $roomtable;

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
     * @return Place
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
     * Set table
     *
     * @param \WW\Gastro\ApiBundle\Entity\RoomTable $table
     *
     * @return Place
     */
    public function setTable(\WW\Gastro\ApiBundle\Entity\RoomTable $table = null)
    {
        $this->table = $table;

        return $this;
    }

    /**
     * Get table
     *
     * @return \WW\Gastro\ApiBundle\Entity\RoomTable
     */
    public function getTable()
    {
        return $this->table;
    }

    /**
     * Set status
     *
     * @param boolean $status
     *
     * @return Place
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return boolean
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set roomtable
     *
     * @param \WW\Gastro\ApiBundle\Entity\Place $roomtable
     *
     * @return Place
     */
    public function setRoomtable(\WW\Gastro\ApiBundle\Entity\Place $roomtable = null)
    {
        $this->roomtable = $roomtable;

        return $this;
    }

    /**
     * Get roomtable
     *
     * @return \WW\Gastro\ApiBundle\Entity\Place
     */
    public function getRoomtable()
    {
        return $this->roomtable;
    }
}
