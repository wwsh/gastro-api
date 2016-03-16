<?php

namespace WW\Gastro\ApiBundle\Tests\Service;

use WW\Gastro\ApiBundle\Entity\Employee;
use WW\Gastro\ApiBundle\Entity\WorkTime;
use WW\Gastro\ApiBundle\Service\EmployeeService;
use Symfony\Bundle\WebProfilerBundle\Tests\TestCase;
use Symfony\Component\HttpKernel\Exception\HttpException;

class EmployeeServiceTest extends TestCase
{

    /**
     * @var EmployeeService
     */
    private $tested;

    public function setUp()
    {
        parent::setUp();

        $this->tested  = new EmployeeService();
    }

    public function testLoginEmployeeNew()
    {
        $employee = new Employee();
        $employee->setWorkingNow(false);

        $this->tested->loginEmployee($employee);

        assertThat($employee->getWorkingNow(), is(true));
        assertThat($this->tested->getCode(), is(200));
        assertThat($this->tested->getMessage(), is('New worktime shift open'));
    }

    public function testLoginEmployeeAlreadyWorking()
    {
        $employee = new Employee();
        $employee->setWorkingNow(false);

        try{
            $this->tested->loginEmployee($employee);
            $this->tested->loginEmployee($employee);
        }
        catch (HttpException $e)
        {

        }

        assertThat($employee->getWorkingNow(), is(true));
        assertThat($e->getStatusCode(), is(412));
        assertThat($e->getMessage(), is('Employee currently at work. No action taken.'));
    }

    public function testLoginEmployeeForgottenLogout()
    {
        $employee = new Employee();
        $employee->setWorkingNow(true);

        $worktime1 = (new WorkTime())->setStart(new \DateTime('2014-10-01'))->setEnd(null); // basically forgot to logout
        $employee->addWorktime($worktime1);
        $this->tested->loginEmployee($employee);

        assertThat($employee->getWorkingNow(), is(true));
        assertThat($this->tested->getCode(), is(200));
        assertThat($this->tested->getMessage(), is('Worktime truncated. New shift re-opened.'));
    }

    public function testLogoutEmployee()
    {
        $employee = new Employee();
        $employee->setWorkingNow(false);

        $this->tested->loginEmployee($employee);
        $this->tested->logoutEmployee($employee);

        assertThat($employee->getWorkingNow(), is(false));
        assertThat($this->tested->getCode(), is(200));
        assertThat($this->tested->getMessage(), is('Employee logged out'));
    }


}