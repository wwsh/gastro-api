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

namespace WW\Gastro\ApiBundle\Tests\Entity;

use WW\Gastro\ApiBundle\Entity\Employee;
use WW\Gastro\ApiBundle\Entity\WorkTime;
use Symfony\Bundle\WebProfilerBundle\Tests\TestCase;

class EmployeeTest extends TestCase
{
    public function testClosePreviousShiftOnNullData()
    {
        $employee = new Employee();
        $employee->closeOpenShift();
        assertThat($employee->getWorktimes()->isEmpty(), is(true));
    }

    public function testCloseOpenShiftOnData()
    {
        $employee = new Employee();
        $worktime = (new WorkTime())->setStart(new \DateTime('2014-10-01'))->setEnd(null);
        $employee->addWorktime($worktime);
        $employee->closeOpenShift();
        assertThat($employee->getWorktimes()[0]->getEnd()->format('Y'), is((new \DateTime())->format('Y')));
    }

    public function testCloseOpenShiftOnDataComplete()
    {
        $employee = new Employee();
        $worktime = (new WorkTime())->setStart(new \DateTime('2014-10-01'))->setEnd(new \DateTime('2014-10-01'));
        $employee->addWorktime($worktime);
        $employee->closeOpenShift();
        assertThat($employee->getWorktimes()[0]->getEnd()->format('Y'), is('2014'));
    }

    public function testGetSortedWorktimes()
    {
        $worktime1 = (new WorkTime())->setStart(new \DateTime('2014-10-01'))->setEnd(new \DateTime('2014-10-01'));
        $worktime2 = (new WorkTime())->setStart(new \DateTime('2013-10-01'))->setEnd(new \DateTime('2013-10-01'));
        $worktime3 = (new WorkTime())->setStart(new \DateTime('2015-10-01'))->setEnd(new \DateTime('2015-10-01'));

        $e = new Employee();
        $e->addWorktime($worktime1)->addWorktime($worktime2)->addWorktime($worktime3);

        $result = $e->getSortedWorktimes();

        assertThat($result[0]->getStart()->format('Y'), is('2015'));
        assertThat($result[1]->getStart()->format('Y'), is('2014'));
        assertThat($result[2]->getStart()->format('Y'), is('2013'));
    }

    public function testShiftOpenToday()
    {
        $worktime1 = (new WorkTime())->setStart(new \DateTime('2014-10-01'))->setEnd(new \DateTime('2014-10-01'));
        $worktime2 = (new WorkTime())->setStart(new \DateTime('2013-10-01'))->setEnd(new \DateTime('2013-10-01'));
        $worktime3 = (new WorkTime())->setStart(new \DateTime('2015-10-01'))->setEnd(new \DateTime('2015-10-01'));

        $e = new Employee();
        $e->addWorktime($worktime1)->addWorktime($worktime2)->addWorktime($worktime3);

        assertThat($e->shiftOpenToday(), is(false));

        $e->addWorktime((new WorkTime())->setStart(new \DateTime()));

        assertThat($e->shiftOpenToday(), is(true));

        $e->closeOpenShift();

        assertThat($e->shiftOpenToday(), is(false));
    }

    public function testOpenShiftForToday()
    {
        $e = new Employee();
        $e->openShiftForToday();
        assertThat($e->shiftOpenToday(), is(true));
        $e->closeOpenShift();
        assertThat($e->shiftOpenToday(), is(false));
        $e->openShiftForToday();
        assertThat($e->getWorktimes()->count(), is(2));
    }
}