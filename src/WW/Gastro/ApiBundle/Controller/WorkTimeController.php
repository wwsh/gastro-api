<?php

namespace WW\Gastro\ApiBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations\View;

class WorkTimeController extends FOSRestController
{
    /**
     * @View
     * @param $employeeId
     * @return \FOS\RestBundle\View\View
     */
    public function getWorktimeAction($employeeId)
    {
        $list = $this
            ->getDoctrine()
            ->getRepository('ApiBundle:Employee')
            ->find($employeeId)
            ->getWorktimes();

        return $this->view($list);
    }
}
