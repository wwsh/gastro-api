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

namespace WW\Gastro\ApiBundle\Tests\Service;

use Mockery;
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
        $manager = Mockery::mock();
        $manager->shouldReceive('persist')->andReturn($manager);
        $manager->shouldReceive('flush')->andReturn($manager);
        $this->tested = new EmployeeService($manager);
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

        try {
            $this->tested->loginEmployee($employee);
            $this->tested->loginEmployee($employee);
        } catch (HttpException $e) {

        }

        assertThat($employee->getWorkingNow(), is(true));
        assertThat($e->getStatusCode(), is(412));
        assertThat($e->getMessage(), is('Employee currently at work. No action taken.'));
    }

    public function testLoginEmployeeForgottenLogout()
    {
        $employee = new Employee();
        $employee->setWorkingNow(true);

        $worktime1 = (new WorkTime())->setStart(new \DateTime('2014-10-01'))
                                     ->setEnd(null); // basically forgot to logout
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
        assertThat($this->tested->getMessage(), is('Employee\'s working shift closed'));
    }


}