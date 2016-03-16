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

namespace WW\Gastro\ApiBundle\Service;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityManager;
use WW\Gastro\ApiBundle\Entity\Employee;
use WW\Gastro\ApiBundle\Entity\WorkTime;
use Symfony\Component\HttpKernel\Exception\HttpException;

/**
 * Class EmployeeService
 * @package WW\Gastro\ApiBundle\Service
 */
class EmployeeService extends CommonEntityService implements CommonEntityServiceInterface
{
    /**
     * This has to be defined for the common engine.
     */
    protected $ENTITY_NAME = 'ApiBundle:Employee';


    /**
     * @param Employee $employee
     */
    public function loginEmployee(Employee $employee)
    {
        if ($employee->getWorkingNow() === false) {
            $employee->closeOpenShift();
            $employee->openShiftForToday();
            $employee->setWorkingNow(true);
            $this->setStatus(200, 'New worktime shift open');
        } else {
            if ($employee->shiftOpenToday()) {
                throw new HttpException(412, 'Employee currently at work. No action taken.');
            } else {
                $employee->closeOpenShift();
                $employee->openShiftForToday();
                $this->setStatus(200, 'Worktime truncated. New shift re-opened.');
            }
        }
        $this->persist($employee);
    }

    public function logoutEmployee(Employee $employee)
    {
        if ($employee->getWorkingNow() === false) {
            throw new HttpException(412, "Employee was not working");
        } else {
            $this->setStatus(200, 'Employee\'s working shift closed');
        }

        $employee->closeOpenShift();
        $employee->setWorkingNow(false);
        $this->persist($employee);
    }

    /**
     * @param $pincode
     * @return array
     */
    public function getByPincode($pincode)
    {
        $employee = $this
            ->manager
            ->getRepository('ApiBundle:Employee')
            ->findBy(['pincode' => $pincode]);

        return $employee;
    }


    /**
     * Nitty persister.
     *
     * @param $manager
     * @param $employee
     */
    private function persist(Employee $employee)
    {
        $worktimes = $employee->getWorktimes();

        foreach ($worktimes as $worktime) {
            $worktime->setEmployee($employee);
            $this->manager->persist($worktime);
        }

        $this->manager->persist($employee);
        $this->manager->flush();
    }


}