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
use WW\Gastro\ApiBundle\Types\BillStatusType;
use WW\Gastro\ApiBundle\ValueObject\Price;

/**
 * Bill
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="WW\Gastro\ApiBundle\Entity\BillRepository")
 */
class Bill
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
     * @var BillStatusType
     *
     * @ORM\Column(name="status", type="billstatus")
     */
    protected $status;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="start", type="datetime")
     */
    protected $start;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="end", type="datetime", nullable=true)
     */
    protected $end;

    /**
     * @var Price
     *
     * @ORM\Column(name="amount", type="price")
     */
    protected $price;

    /**
     * @ORM\ManyToOne(targetEntity="Employee", inversedBy="bill")
     * @ORM\JoinColumn(name="employee_id", referencedColumnName="id")
     */
    protected $employee;


    /**
     * @ORM\ManyToOne(targetEntity="WorkTime", inversedBy="bill")
     * @ORM\JoinColumn(name="worktime_id", referencedColumnName="id")
     */
    protected $worktime;

    /**
     * @var BillOrder[]
     *
     * @ORM\OneToMany(targetEntity="BillOrder", mappedBy="bill")
     */
    protected $orders;

    /**
     * @ORM\ManyToOne(targetEntity="PaymentType", inversedBy="bill")
     * @ORM\JoinColumn(name="paymenttype_id", referencedColumnName="id")
     */
    protected $paymentType;

    /**
     * @ORM\ManyToOne(targetEntity="Place", inversedBy="bill")
     * @ORM\JoinColumn(name="place_id", referencedColumnName="id")
     */
    protected $place;

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
     * @return Bill
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
     * Set start
     *
     * @param \DateTime $start
     *
     * @return Bill
     */
    public function setStart($start)
    {
        $this->start = $start;

        return $this;
    }

    /**
     * Get start
     *
     * @return \DateTime
     */
    public function getStart()
    {
        return $this->start;
    }

    /**
     * Set end
     *
     * @param \DateTime $end
     *
     * @return Bill
     */
    public function setEnd($end)
    {
        $this->end = $end;

        return $this;
    }

    /**
     * Get end
     *
     * @return \DateTime
     */
    public function getEnd()
    {
        return $this->end;
    }

    /**
     * Set amount
     *
     * @param Price $price
     *
     * @return Bill
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get amount
     *
     * @return Price
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set employee
     *
     * @param \WW\Gastro\ApiBundle\Entity\Employee $employee
     *
     * @return Bill
     */
    public function setEmployee(\WW\Gastro\ApiBundle\Entity\Employee $employee = null)
    {
        $this->employee = $employee;

        return $this;
    }

    /**
     * Get employee
     *
     * @return \WW\Gastro\ApiBundle\Entity\Employee
     */
    public function getEmployee()
    {
        return $this->employee;
    }

    /**
     * Set worktime
     *
     * @param \WW\Gastro\ApiBundle\Entity\WorkTime $worktime
     *
     * @return Bill
     */
    public function setWorktime(\WW\Gastro\ApiBundle\Entity\WorkTime $worktime = null)
    {
        $this->worktime = $worktime;

        return $this;
    }

    /**
     * Get worktime
     *
     * @return \WW\Gastro\ApiBundle\Entity\WorkTime
     */
    public function getWorktime()
    {
        return $this->worktime;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->orders = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add order
     *
     * @param \WW\Gastro\ApiBundle\Entity\BillOrder $order
     *
     * @return Bill
     */
    public function addOrder(\WW\Gastro\ApiBundle\Entity\BillOrder $order)
    {
        $this->orders[] = $order;

        return $this;
    }

    /**
     * Remove order
     *
     * @param \WW\Gastro\ApiBundle\Entity\BillOrder $order
     */
    public function removeOrder(\WW\Gastro\ApiBundle\Entity\BillOrder $order)
    {
        $this->orders->removeElement($order);
    }

    /**
     * Get orders
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getOrders()
    {
        return $this->orders;
    }

    /**
     * Set place
     *
     * @param \WW\Gastro\ApiBundle\Entity\Place $place
     *
     * @return Bill
     */
    public function setPlace(\WW\Gastro\ApiBundle\Entity\Place $place = null)
    {
        $this->place = $place;

        return $this;
    }

    /**
     * Get place
     *
     * @return \WW\Gastro\ApiBundle\Entity\Place
     */
    public function getPlace()
    {
        return $this->place;
    }

    /**
     * Set paymentType
     *
     * @param \WW\Gastro\ApiBundle\Entity\PaymentType $paymentType
     *
     * @return Bill
     */
    public function setPaymentType(\WW\Gastro\ApiBundle\Entity\PaymentType $paymentType = null)
    {
        $this->paymentType = $paymentType;

        return $this;
    }

    /**
     * Get paymentType
     *
     * @return \WW\Gastro\ApiBundle\Entity\PaymentType
     */
    public function getPaymentType()
    {
        return $this->paymentType;
    }
}
