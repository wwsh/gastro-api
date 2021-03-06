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

namespace WW\Gastro\ApiBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;
use FOS\RestBundle\Controller\Annotations\View;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

class BillController extends FOSRestController
{
    /**
     * @View
     * @param $employeeId
     * @return \Doctrine\Common\Collections\Collection
     * @ApiDoc(
     *  resource=true,
     *  description="Getting all the currently running Bills by Employer",
     *  requirements={
     *      {
     *          "name"="employeeId",
     *          "dataType"="integer",
     *          "requirement"="true",
     *          "description"="Employee ID"
     *      }
     *  },
     *     statusCodes={
     *         200="Returned when successful",
     *         404="Returned when the Employee does not exist"
     *     }
     * )
     */
    public function getBillsAction($employeeId)
    {
        $employee = $this->get('employee.service')->get($employeeId);

        if (!$employee) {
            throw new HttpException(404, "Employee not found");
        }

        return $this->view($employee->getBills());
    }

    /**
     * @View
     * @param $employeeId
     * @param $billId
     * @return \Doctrine\Common\Collections\Collection
     * @ApiDoc(
     *  resource=true,
     *  description="Getting single Bill data",
     *  requirements={
     *      {
     *          "name"="employeeId",
     *          "dataType"="integer",
     *          "requirement"="Integer",
     *          "description"="Employee ID"
     *      },
     *      {
     *          "name"="billId",
     *          "dataType"="integer",
     *          "requirement"="Integer",
     *          "description"="Employee ID"
     *      },
     *  },
     *     statusCodes={
     *         200="Returned when successful",
     *         404="Returned when the Employee or Bill does not exist"
     *     }
     * )
     */
    public function getBillAction($employeeId, $billId)
    {
        $employee = $this->get('employee.service')->get($employeeId);

        if (!$employee) {
            throw new HttpException(404, "Employee not found");
        }

        $bill = $this->get('bill.service')->get($billId);

        if (!$bill) {
            throw new HttpException(404, "Bill not found");
        }

        return $this->view($bill);
    }

    /**
     * @View
     * @param Request $request
     * @param         $employeeId
     * @return \Doctrine\Common\Collections\Collection
     * @internal param $billId
     * @ApiDoc(
     *  resource=true,
     *  description="Adding new Bill",
     *  requirements={
     *      {
     *          "name"="employeeId",
     *          "dataType"="integer",
     *          "requirement"="true",
     *          "description"="Employee ID"
     *      },
     *     {
     *          "name"="start",
     *          "dataType"="date",
     *          "requirement"="false",
     *          "description"="If omitted, current date will be used"
     *     },
     *     {
     *          "name"="end",
     *          "dataType"="date",
     *          "requirement"="false",
     *          "description"="Set to null. Will be autoset on closing the Bill"
     *     }
     *
     *  },
     * input="WW\Gastro\ApiBundle\Entity\Bill",
     *     statusCodes={
     *         200="Returned when successfully added",
     *         404="Returned when the Employee does not exist"
     *     }
     * )
     */
    public function postBillAction(Request $request, $employeeId)
    {
        $employee = $this->get('employee.service')->get($employeeId);

        if (!$employee) {
            throw new HttpException(404, "Employee not found");
        }

        $service = $this->get('bill.service');

        $service->setContext($employee)
                ->post($request->request->all());

        return $this->view(
            [
                'message' => $service->getMessage(),
                'code'    => $service->getCode()
            ]
        );
    }

    /**
     * @View
     * @param Request $request
     * @param         $employeeId
     * @return \Doctrine\Common\Collections\Collection
     * @internal param $billId
     * @ApiDoc(
     *  resource=true,
     *  description="Updating new Bill",
     *  requirements={
     *      {
     *          "name"="employeeId",
     *          "dataType"="integer",
     *          "requirement"="true",
     *          "description"="Employee ID"
     *      }
     *  },
     * input="WW\Gastro\ApiBundle\Entity\Bill",
     *     statusCodes={
     *         200="Returned when successfully updated",
     *         404="Returned when the Employee does not exist"
     *     }
     * )
     */
    public function patchBillAction(Request $request, $employeeId)
    {
        $employee = $this->get('employee.service')->get($employeeId);

        if (!$employee) {
            throw new HttpException(404, "Employee not found");
        }

        $service = $this->get('bill.service');

        $service->setContext($employee)
                ->patch($request->request->all());

        return $this->view(
            [
                'message' => $service->getMessage(),
                'code'    => $service->getCode()
            ]
        );
    }
}