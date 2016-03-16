<?php
/*******************************************************************************
 *  The MIT License (MIT)
 *
 * Copyright (c) 2016 WW Software House
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated
 * documentation files (the "Software"), to deal in the Software without restriction, including without limitation the
 * rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to
 * permit persons to whom the Software is furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all copies or substantial portions of the
 * Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE
 * WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS
 * OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR
 * OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 ******************************************************************************/

namespace WW\Gastro\ApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use WW\Gastro\ApiBundle\Types\OrderStatusType;

/**
 * BillOrder
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class BillOrder
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
     * @var OrderStatusType
     *
     * @ORM\Column(name="status", type="orderstatus")
     */
    protected $status;

    /**
     * @ORM\ManyToOne(targetEntity="Bill", inversedBy="billorders")
     * @ORM\JoinColumn(name="bill_id", referencedColumnName="id")
     */
    protected $bill;

    /**
     * @ORM\ManyToMany(targetEntity="Product", inversedBy="billorders")
     * @ORM\JoinTable(name="OrdersHaveProducts")
     */
    protected $products;

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
     * Set status
     *
     * @param string $status
     *
     * @return BillOrder
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->products = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set bill
     *
     * @param \WW\Gastro\ApiBundle\Entity\Bill $bill
     *
     * @return BillOrder
     */
    public function setBill(\WW\Gastro\ApiBundle\Entity\Bill $bill = null)
    {
        $this->bill = $bill;

        return $this;
    }

    /**
     * Get bill
     *
     * @return \WW\Gastro\ApiBundle\Entity\Bill
     */
    public function getBill()
    {
        return $this->bill;
    }

    /**
     * Add product
     *
     * @param \WW\Gastro\ApiBundle\Entity\Product $product
     *
     * @return BillOrder
     */
    public function addProduct(\WW\Gastro\ApiBundle\Entity\Product $product)
    {
        $this->products[] = $product;

        return $this;
    }

    /**
     * Remove product
     *
     * @param \WW\Gastro\ApiBundle\Entity\Product $product
     */
    public function removeProduct(\WW\Gastro\ApiBundle\Entity\Product $product)
    {
        $this->products->removeElement($product);
    }

    /**
     * Get products
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getProducts()
    {
        return $this->products;
    }
}
