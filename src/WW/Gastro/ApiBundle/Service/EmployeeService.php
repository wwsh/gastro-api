<?php

namespace WW\Gastro\ApiBundle\Service;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityManager;
use WW\Gastro\ApiBundle\Entity\Employee;
use WW\Gastro\ApiBundle\Entity\WorkTime;
use Symfony\Component\HttpKernel\Exception\HttpException;

class EmployeeService
{

    /**
     * @var
     */
    private $code;

    /**
     * @var
     */
    private $message;


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
    }

    public function logoutEmployee(Employee $employee)
    {
        if ($employee->getWorkingNow() === false) {
            throw new HttpException(412, "Employee was not working");
        } else {
            $this->setStatus(200, 'Employee logged out');
        }

        $employee->closeOpenShift();
        $employee->setWorkingNow(false);

    }

    /**
     * @return mixed
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @return mixed
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param $code
     * @param $message
     */
    private function setStatus($code, $message)
    {
        $this->code = $code;
        $this->message = $message;
    }

    /**
     * Nitty persister.
     *
     * @param $manager
     * @param $employee
     */
    public function persist(ObjectManager $manager, Employee $employee)
    {
        $worktimes = $employee->getWorktimes();

        foreach ($worktimes as $worktime) {
            $worktime->setEmployee($employee);
            $manager->persist($worktime);
        }

        $manager->persist($employee);
        $manager->flush();
    }


}