<?php

namespace WW\Gastro\ApiBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
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
    public function getBillsAction($employeeId)
    {
        $employee = $this
            ->getDoctrine()
            ->getRepository('ApiBundle:Employee')
            ->find($employeeId);

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
        $employee = $this
            ->getDoctrine()
            ->getRepository('ApiBundle:Employee')
            ->find($employeeId);

        if (!$employee) {
            throw new HttpException(404, "Employee not found");
        }

        $bill = $this
            ->getDoctrine()
            ->getRepository('ApiBundle:Bill')
            ->find($billId);

        if (!$bill) {
            throw new HttpException(404, "Bill not found");
        }

        return $this->view($bill);
    }
}