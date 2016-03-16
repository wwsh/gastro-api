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
use WW\Gastro\ApiBundle\Types\SexType;


/**
 * Employee
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="WW\Gastro\ApiBundle\Entity\EmployeeRepository")
 */
class Employee
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
     * @var string
     *
     * @ORM\Column(name="surname", type="string", length=255)
     */
    private $surname;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="started", type="datetime")
     */
    private $started;

    /**
     * @var boolean
     *
     * @ORM\Column(name="status", type="boolean")
     */
    private $status = true;

    /**
     * @var boolean
     *
     * @ORM\Column(name="deleted", type="boolean")
     */
    private $deleted = false;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="birthdate", type="datetime")
     */
    private $birthdate;

    /**
     * @var SexType
     *
     * @ORM\Column(name="sex", type="sex")
     */
    private $sex;

    /**
     * @var string
     *
     * @ORM\Column(name="pincode", type="string")
     */
    private $pincode;

    /**
     * @var boolean
     *
     * @ORM\Column(name="workingNow", type="boolean")
     */
    private $workingNow = false;

    /**
     * @ORM\ManyToOne(targetEntity="Business", inversedBy="employees")
     * @ORM\JoinColumn(name="business_id", referencedColumnName="id")
     */
    protected $business;

    /**
     * @var WorkTime[]
     *
     * @ORM\OneToMany(targetEntity="WorkTime", mappedBy="employee")
     */
    protected $worktimes;

    /**
     * @var Bill[]
     *
     * @ORM\OneToMany(targetEntity="Bill", mappedBy="employee")
     */
    protected $bills;

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
     * @return Employee
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
     * Set surname
     *
     * @param string $surname
     *
     * @return Employee
     */
    public function setSurname($surname)
    {
        $this->surname = $surname;

        return $this;
    }

    /**
     * Get surname
     *
     * @return string
     */
    public function getSurname()
    {
        return $this->surname;
    }

    /**
     * Set started
     *
     * @param \DateTime $started
     *
     * @return Employee
     */
    public function setStarted($started)
    {
        $this->started = $started;

        return $this;
    }

    /**
     * Get started
     *
     * @return \DateTime
     */
    public function getStarted()
    {
        return $this->started;
    }

    /**
     * Set status
     *
     * @param boolean $status
     *
     * @return Employee
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
     * Set birthdate
     *
     * @param \DateTime $birthdate
     *
     * @return Employee
     */
    public function setBirthdate($birthdate)
    {
        $this->birthdate = $birthdate;

        return $this;
    }

    /**
     * Get birthdate
     *
     * @return \DateTime
     */
    public function getBirthdate()
    {
        return $this->birthdate;
    }

    /**
     * Set sex
     *
     * @param string $sex
     *
     * @return Employee
     */
    public function setSex($sex)
    {
        $this->sex = $sex;

        return $this;
    }

    /**
     * Get sex
     *
     * @return string
     */
    public function getSex()
    {
        return $this->sex;
    }

    /**
     * Set business
     *
     * @param \WW\Gastro\ApiBundle\Entity\Business $business
     *
     * @return Employee
     */
    public function setBusiness(\WW\Gastro\ApiBundle\Entity\Business $business = null)
    {
        $this->business = $business;

        return $this;
    }

    /**
     * Get business
     *
     * @return \WW\Gastro\ApiBundle\Entity\Business
     */
    public function getBusiness()
    {
        return $this->business;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->worktimes = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add worktime
     *
     * @param \WW\Gastro\ApiBundle\Entity\WorkTime $worktime
     *
     * @return Employee
     */
    public function addWorktime(\WW\Gastro\ApiBundle\Entity\WorkTime $worktime)
    {
        $this->worktimes[] = $worktime;

        return $this;
    }

    /**
     * Remove worktime
     *
     * @param \WW\Gastro\ApiBundle\Entity\WorkTime $worktime
     */
    public function removeWorktime(\WW\Gastro\ApiBundle\Entity\WorkTime $worktime)
    {
        $this->worktimes->removeElement($worktime);
    }

    /**
     * Get worktimes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getWorktimes()
    {
        return $this->worktimes;
    }

    /**
     * Set pincode
     *
     * @param string $pincode
     *
     * @return Employee
     */
    public function setPincode($pincode)
    {
        $this->pincode = $pincode;

        return $this;
    }

    /**
     * Get pincode
     *
     * @return string
     */
    public function getPincode()
    {
        return $this->pincode;
    }

    /**
     * Set logged
     *
     * @param string $logged
     *
     * @return Employee
     */
    public function setLogged($logged)
    {
        $this->logged = $logged;

        return $this;
    }

    /**
     * Get logged
     *
     * @return string
     */
    public function getLogged()
    {
        return $this->logged;
    }

    /**
     * Set havingSession
     *
     * @param boolean $havingSession
     *
     * @return Employee
     */
    public function setHavingSession($havingSession)
    {
        $this->havingSession = $havingSession;

        return $this;
    }

    /**
     * Get havingSession
     *
     * @return boolean
     */
    public function getHavingSession()
    {
        return $this->havingSession;
    }

    /**
     * Set workingNow
     *
     * @param boolean $workingNow
     *
     * @return Employee
     */
    public function setWorkingNow($workingNow)
    {
        $this->workingNow = $workingNow;

        return $this;
    }

    /**
     * Get workingNow
     *
     * @return boolean
     */
    public function getWorkingNow()
    {
        return $this->workingNow;
    }

    /**
     * Custom method.
     * Returns true, if has worktime open for this day.
     *
     * @param \DateTime $dateTime
     * @return bool
     */
    public function shiftOpenToday(\DateTime $dateTime = null)
    {
        if (empty($this->worktimes)) {
            return false;
        }

        if ($dateTime === null) {
            $dateTime = new \DateTime();
        }

        foreach ($this->worktimes as $worktime) {
            $start = $worktime->getStart();
            $end   = $worktime->getEnd();
            if (null === $end && $start->format('Ymd') === $dateTime->format('Ymd')) {
                return true;
            }
        }

        return false;
    }

    /**
     * Closing not a properly closed worktime "shift".
     */
    public function closeOpenShift()
    {
        $worktimes = $this->getSortedWorktimes();

        if (empty($worktimes)) {
            return;
        }

        if ($worktimes[0]->getEnd() === null) {
            $worktimes[0]->setEnd(new \DateTime());
        }
    }


    /**
     * @return array|\Doctrine\Common\Collections\Collection
     */
    public function getSortedWorktimes()
    {
        $worktimes = $this->getWorktimes();

        if (empty($worktimes)) {
            return $worktimes;
        }

        $array = [];

        foreach ($worktimes as $worktime) {
            $key         = $worktime->getStart()->format('YmdHis');
            $array[$key] = $worktime;
        }

        krsort($array);

        $array = array_values($array);

        return $array;
    }

    public function openShiftForToday()
    {
        $this->closeOpenShift(); // make sure no other shifts are running
        $worktime = new WorkTime();
        $worktime->setStart(new \DateTime());
        $this->addWorktime($worktime);
    }


    /**
     * Set deleted
     *
     * @param boolean $deleted
     *
     * @return Employee
     */
    public function setDeleted($deleted)
    {
        $this->deleted = $deleted;

        return $this;
    }

    /**
     * Get deleted
     *
     * @return boolean
     */
    public function getDeleted()
    {
        return $this->deleted;
    }

    /**
     * Add bill
     *
     * @param \WW\Gastro\ApiBundle\Entity\Bill $bill
     *
     * @return Employee
     */
    public function addBill(\WW\Gastro\ApiBundle\Entity\Bill $bill)
    {
        $this->bills[] = $bill;

        return $this;
    }

    /**
     * Remove bill
     *
     * @param \WW\Gastro\ApiBundle\Entity\Bill $bill
     */
    public function removeBill(\WW\Gastro\ApiBundle\Entity\Bill $bill)
    {
        $this->bills->removeElement($bill);
    }

    /**
     * Get bills
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getBills()
    {
        return $this->bills;
    }
}
