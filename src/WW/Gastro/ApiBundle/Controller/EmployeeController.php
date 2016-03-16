<?php

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
     * @var EmployeeService
     */
    private $service;


    /**
     * EmployeeController constructor.
     */
    public function __construct()
    {
        $this->service = new EmployeeService();
    }


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
        $employee = $this
            ->getDoctrine()
            ->getRepository('ApiBundle:Employee')
            ->find($employeeId);

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
        $list = $this
            ->getDoctrine()
            ->getRepository('ApiBundle:Employee')
            ->findAll();

        return $this->view($list);
    }


    /**
     * @View
     * @param $employeeId
     * @return \FOS\RestBundle\View\View
     * @internal param Employee $employee
     * @ApiDoc(
     *  resource=true,
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
    public function putEmployeeLoginAction($employeeId)
    {
        $employee = $this->getEmployeeAction($employeeId);

        if (!$employee) {
            throw new HttpException('Employee not found');
        }

        $this->service->loginEmployee($employee);
        $this->service->persist($this->getDoctrine()->getManager(), $employee);

        return $this->view(
            $this->service->getMessage(),
            $this->service->getCode()
        );

    }

    /**
     * @View
     * @param $employeeId
     * @return \FOS\RestBundle\View\View
     * @ApiDoc(
     *  resource=true,
     *  description="Ending Employee's work",
     *  requirements={
     *      {
     *          "name"="employeeId",
     *          "dataType"="integer",
     *          "requirement"="Integer",
     *          "description"="ID of Employee to be work-closed"
     *      }
     *  },
     *     statusCodes={
     *         200="Returned when worktime closed",
     *         412="Returned when Employee was not working",
     *         400="Returned if Employee not found"
     *     }
     * )
     */
    public function putEmployeeLogoutAction($employeeId)
    {
        $employee = $this->getEmployeeAction($employeeId);

        if (!$employee) {
            throw new HttpException('Employee not found');
        }

        $this->service->logoutEmployee($employee);
        $this->service->persist($this->getDoctrine()->getManager(), $employee);

        return $this->view(
            $this->service->getMessage(),
            $this->service->getCode()
        );
    }

    /**
     * @View
     * @param Request $request
     * @return \FOS\RestBundle\View\View
     * @ApiDoc(
     *  resource=true,
     *  description="Identifying Employee by PIN code, stored in database",
     *  requirements={
     *      {
     *          "name"="pincode",
     *          "dataType"="integer",
     *          "requirement"="Integer",
     *          "description"="PIN code value"
     *      }
     *  },
     *     statusCodes={
     *         200="Returned when Employee found",
     *         400="Returned if Employee not found"
     *     }
     * )
     */
    public function postEmployeePincodeAction(Request $request)
    {
        $data = $request->request->all();

        if (isset($data['pincode'])) {

            $employee = $this
                ->getDoctrine()
                ->getRepository('ApiBundle:Employee')
                ->findBy(['pincode' => $data['pincode']]);

            if (!empty($employee)) {
                return $this->view($employee);
            }
        }

        throw new HttpException(404, "Employee not found");
    }
}
