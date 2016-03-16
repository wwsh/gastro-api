<?php

namespace WW\Gastro\ApiBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use WW\Gastro\ApiBundle\Entity\Business;
use FOS\RestBundle\Controller\Annotations\View;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\HttpKernel\Exception\HttpException;

class BusinessController extends FOSRestController
{

    /**
     * @View
     * @param $id
     * @return \FOS\RestBundle\View\View
     * @throws HttpException*
     * @ApiDoc(
     *  resource=true,
     *  description="Getting single Business data",
     *  requirements={
     *      {
     *          "name"="id",
     *          "dataType"="integer",
     *          "requirement"="Integer",
     *          "description"="Business ID"
     *      }
     *  },
     *     statusCodes={
     *         200="Returned when successful",
     *         404="Returned when the Business does not exist"
     *     }
     * )
     */
    public function getBusinessAction($id)
    {
        $business = $this
            ->getDoctrine()
            ->getRepository('ApiBundle:Business')
            ->find($id);

        if (!$business) {
            throw new HttpException(404, "Business not found");
        }

        return $this->view($business);
    }


    /**
     * @View
     * @return \FOS\RestBundle\View\View
     * @ApiDoc(
     *  resource=true,
     *  description="Getting all the Businesses",
     *  output="[]"
     * )

     */
    public function getBusinessesAction()
    {
        $list = $this
            ->getDoctrine()
            ->getRepository('ApiBundle:Business')
            ->findAll();

        return $this->view($list);
    }
}
