<?php

namespace App\Storage;

interface StorageAwareInterface
{
    /**
     * Sets storage for object
     *
     * @param object $storage
     */
    public function setStorage($storage);
}