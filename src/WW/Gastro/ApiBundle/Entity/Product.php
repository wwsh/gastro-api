<?php

namespace WW\Gastro\ApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use WW\Gastro\ApiBundle\ValueObject\Price;

/**
 * Product
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="WW\Gastro\ApiBundle\Entity\ProductRepository")
 */
class Product
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    protected $name;

    /**
     * @ORM\Column(name="status", type="boolean")
     * @var bool
     */
    protected $status = true;

    /**
     * @ORM\Column(name="price", type="price")
     * @var Price
     */
    protected $price;

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
     * @return Product
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
     * Set status
     *
     * @param boolean $status
     *
     * @return Product
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
     * Set price
     *
     * @param Price $price The price VO.
     *
     * @return Product
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return Price
     */
    public function getPrice()
    {
        return $this->price;
    }
}
