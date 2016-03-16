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
