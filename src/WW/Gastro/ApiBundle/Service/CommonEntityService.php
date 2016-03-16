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

namespace WW\Gastro\ApiBundle\Service;

use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpKernel\Exception\HttpException;

/**
 * Class CommonEntityService
 * @package WW\Gastro\ApiBundle\Service
 */
class CommonEntityService implements CommonEntityServiceInterface
{
    const ENTITY_NAMESPACE = 'WW\\Gastro\\ApiBundle\\Entity\\';

    /**
     * Please overwrite me in the child classes.
     */
    protected $ENTITY_NAME = '';

    /**
     * @var
     */
    protected $code;

    /**
     * @var
     */
    protected $message;

    /**
     * @var EntityManager
     */
    protected $manager;

    /**
     * Each operation can be performed in context of another entity, if needed.
     *
     * @var
     */
    protected $contextEntity;

    /**
     * EmployeeService constructor.
     * @param $manager
     */
    public function __construct($manager)
    {
        $this->manager = $manager;
    }

    /**
     * @param mixed $contextEntity
     * @return $this
     */
    public function setContext($contextEntity)
    {
        $this->contextEntity = $contextEntity;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @return mixed
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @return mixed
     */
    public function getAll()
    {
        return $this
            ->manager
            ->getRepository($this->ENTITY_NAME)
            ->findAll();
    }

    /**
     * @param $id
     * @return mixed
     */
    public function get($id)
    {
        return $this
            ->manager
            ->getRepository($this->ENTITY_NAME)
            ->find($id);
    }

    /**
     * @param $dataArray
     */
    public function post($dataArray)
    {
        if (!is_array($dataArray)) {
            throw new HttpException(400, 'No input data');
        }

        if (!isset($dataArray['id'])) {
            // a new entity is being added
            $parts      = explode(':', $this->ENTITY_NAME);
            $entityName = end($parts);

            $entityClassName = self::ENTITY_NAMESPACE . $entityName;

            $entity = new $entityClassName;
        } else {
            // a massive update of existing entity
            $entity = $this->get($dataArray['id']);
            unset($dataArray['id']);
        }

        $this->setOnEntity($dataArray, $entity);

        $this->manager->persist($entity);
        $this->manager->flush();

        $this->setStatus(200, 'OK');

        return true;
    }

    /**
     * @param $dataArray
     */
    public function put($dataArray)
    {
        // TODO: Implement put() method.
    }


    /**
     * @param $dataArray
     * @return bool
     */
    public function patch($dataArray)
    {
        if (!is_array($dataArray)) {
            throw new HttpException(400, 'No input data');
        }

        if (!isset($dataArray['id'])) {
            throw new HttpException(400, 'No ID given to use PATCH');
        }

        $entity = $this->get($dataArray['id']);

        if (!$dataArray) {
            throw new HttpException(400, 'No ' . $this->ENTITY_NAME . ' with that ID exists');
        }

        unset($dataArray['id']);

        $this->setOnEntity($dataArray, $entity);

        $this->manager->persist($entity);
        $this->manager->flush();

        $this->setStatus(200, 'OK');

        return true;
    }

    /**
     * @param $code
     * @param $message
     */
    protected function setStatus($code, $message)
    {
        $this->code    = $code;
        $this->message = $message;
    }

    /**
     * @param $dataArray
     * @param $entity
     */
    public function setOnEntity($dataArray, $entity)
    {
        foreach ($dataArray as $key => $value) {
            if ('_' === $key[0]) {
                continue;
            }

            $setter = 'set' . ucfirst($key);

            if (!is_callable([$entity, $setter])) {
                throw new HttpException(400, 'Not possible to set the value for: ' . $key);
            }

            $entity->$setter($value);
        }
    }

}