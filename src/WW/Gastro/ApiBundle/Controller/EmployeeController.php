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
use WW\Gastro\ApiBundle\Entity\Employee;
use WW\Gastro\ApiBundle\Service\Controls;
use WW\Gastro\ApiBundle\Service\EmployeeService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;
use FOS\RestBundle\Controller\Annotations\View;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

/**
 * Class EmployeeController
 * @package WW\Gastro\ApiBundle\Controller
 */
class EmployeeController extends FOSRestController
{


    /**
     * @View
     * @param $employeeId
     * @return \FOS\RestBundle\View\View
     * @ApiDoc(
     *  resource=true,
     *  description="Getting single Employee data",
     *  requirements={
     *      {
     *          "name"="employeeId",
     *          "dataType"="integer",
     *          "requirement"="Integer",
     *          "description"="Employee ID"
     *      }
     *  },
     *     statusCodes={
     *         200="Returned when successful",
     *         404="Returned when the Employee does not exist"
     *     }
     * )
     */
    public function getEmployeeAction($employeeId)
    {
        $employee = $this->get('employee.service')->get($employeeId);

        if (!$employee) {
            throw new HttpException(404, 'Employee not found');
        }

        return $this->view($employee);
    }

    /**
     * @View
     * @return \FOS\RestBundle\View\View
     * @ApiDoc(
     *  resource=true,
     *  description="Getting a list of all Employees"
     * )
     */
    public function getEmployeesAction()
    {
        $list = $this->get('employee.service')->getAll();

        return $this->view($list);
    }


    /**
     * @View
     * @param $employeeId
     * @return \FOS\RestBundle\View\View
     * @internal param Employee $employee
     * @ApiDoc(
     *  resource=false,
     *  description="Starting Employee's work",
     *  requirements={
     *      {
     *          "name"="employeeId",
     *          "dataType"="integer",
     *          "requirement"="Integer",
     *          "description"="Employee ID to be registered as working"
     *      }
     *  },
     *     statusCodes={
     *         200="Returned when new worktime open or re-open",
     *         412="Returned when Employee already at work - no action taken",
     *         400="Returned if Employee not found"
     *     }
     * )
     */
    public function postEmployeeLoginAction($employeeId)
    {
        $employee = $this->get('employee.service')->get($employeeId);

        if (!$employee) {
            throw new HttpException('Employee not found');
        }

        $service = $this->get('employee.service');

        $service->loginEmployee($employee);

        return $this->view(
            [
                'message' => $service->getMessage(),
                'code'    => $service->getCode()
            ]
        );

    }

    /**
     * @View
     * @param $employeeId
     * @return \FOS\RestBundle\View\View
     * @ApiDoc(
     *  resource=false,
     *  description="Ending Employee's work",
     *  requirements={
     *      {
     *          "name"="employeeId",
     *          "dataType"="integer",
     *          "requirement"="Integer",
     *          "description"="ID of Employee to stop working shift"
     *      }
     *  },
     *     statusCodes={
     *         200="Returned when worktime closed",
     *         412="Returned when Employee was not working",
     *         400="Returned if Employee not found"
     *     }
     * )
     */
    public function postEmployeeLogoutAction($employeeId)
    {
        $employee = $this->get('employee.service')->get($employeeId);

        if (!$employee) {
            throw new HttpException('Employee not found');
        }

        $service = $this->get('employee.service');

        $service->logoutEmployee($employee);

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
     * @return \FOS\RestBundle\View\View
     * @ApiDoc(
     *  resource=true,
     *  description="Search Employee by pincode",
     *  requirements={
     *      {
     *          "name"="pincode",
     *          "dataType"="integer",
     *          "requirement"="Integer",
     *          "description"="PIN code value"
     *      }
     *  },
     *      output="WW\Gastro\ApiBundle\Entity\Employee",
     *     statusCodes={
     *         200="Returned when Employee found",
     *         400="Returned if Employee not found"
     *     }
     * )
     */
    public function getEmployeePincodeAction(Request $request)
    {
        $pincode = $request->query->get('pincode');

        if ($pincode) {

            $employee = $this->get('employee.service')->getByPincode($pincode);

            if (!empty($employee)) {
                return $this->view($employee);
            }
        }

        throw new HttpException(404, "Employee not found");
    }

    /**
     * @View
     * @param Request $request
     * @param         $employeeId
     * @return \FOS\RestBundle\View\View
     * @ApiDoc(
     *  resource=true,
     *  description="Update Employee data",
     *      input="WW\Gastro\ApiBundle\Entity\Employee",
     *  requirements={
     *      {
     *          "name"="id",
     *          "dataType"="integer",
     *          "requirement"="Integer",
     *          "description"="Employee ID"
     *      }
     *  },
     *     statusCodes={
     *         200="Returned when update successful",
     *         400="Returned if Employee not found"
     *     }
     * )
     */
    public function patchEmployeeAction(Request $request)
    {
        $service = $this->get('employee.service');

        $service->patch($request->request->all());

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
     * @return \FOS\RestBundle\View\View
     * @ApiDoc(
     *  resource=true,
     *  description="Add Employee data",
     *      input="WW\Gastro\ApiBundle\Entity\Employee",
     *     statusCodes={
     *         200="Returned when insert successful"
     *     }
     * )
     */
    public function postEmployeeAction(Request $request)
    {
        $service = $this->get('employee.service');

        $service->post($request->request->all());

        return $this->view(
            [
                'message' => $service->getMessage(),
                'code'    => $service->getCode()
            ]
        );
    }
}
