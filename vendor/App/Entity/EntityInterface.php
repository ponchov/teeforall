<?php

namespace App\Entity;

interface EntityInterface
{
    /**
     * Sets new data for object from given array
     *
     * @param array $data
     */
    public function exchangeArray(array $data);

    /**
     * Returns values of entity as array
     *
     * @return array
     */
    public function getValues();

    /**
     * Returns the attribute name that is the unique key within that entities
     *
     * @return string
     */
    public function getKeyName();

    /**
     * Returns the value of key attribute
     *
     * @return mixed
     */
    public function getKeyValue();
}