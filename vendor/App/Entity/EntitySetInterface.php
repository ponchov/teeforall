<?php

namespace App\Entity;

use App\Entity\Service\FactoryInterface;

interface EntitySetInterface extends \Iterator, \Countable, \ArrayAccess
{
    /**
     * Sets data for EntitySet
     *
     * @param mixed $set
     */
    public function set($set);

    /**
     * Adds data to EntitySet
     *
     * @param mixed $data
     */
    public function add($data);

    /**
     * Returns EntitySet as converted into array
     *
     * @return array
     */
    public function toArray();

    /**
     * Resets data in EntitySet
     */
    public function reset();

    /**
     * Sets factory for creating entities in EntitySet
     *
     * @param FactoryInterface $factory
     */
    public function setFactory(FactoryInterface $factory);

    /**
     * Returns the factory of EntitySet
     * 
     * @return FactoryInterface
     */
    public function getFactory();
}