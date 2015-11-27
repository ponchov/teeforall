<?php

namespace App\Entity\Service;

use App\Entity\EntityInterface;

interface FactoryInterface
{
    /**
     * Creates new entity
     *
     * @param mixed $data
     * @return \App\Entity\EntityInterface
     */
    public function create($data);

    /**
     * Returns entity prototype
     *
     */
    public function getEntityProto();

    /**
     * Set entity prototype
     *
     * @param \App\Entity\EntityInterface $entityProto
     */
    public function setEntityProto(EntityInterface $entityProto);

    /**
     * Returns class of object that factory can create
     *
     * @return string
     */
    public function getInstanceClass();
}