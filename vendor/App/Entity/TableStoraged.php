<?php

namespace App\Entity;

use App\Storage\Table\Simple as TableStorage;

trait TableStoraged
{
    /**
     *
     * @var TableStorage
     */
    protected $storage = null;

    /**
     *
     * @param TableStorage $storage
     * @return mixed
     */
    public function setStorage($storage)
    {
        if (!$storage instanceof TableStorage) {
            throw new \RuntimeException('Storage must be instance or extend of App\Storage\Table\Simple');
        }
        
        $this->storage = $storage;

        return $this;
    }

    /**
     * 
     *
     * @return mixed
     */
    public function save()
    {
        $this->getStorage()->save($this);

        return $this;
    }

    /**
     * 
     *
     * @return mixed
     */
    public function delete()
    {
        $this->getStorage()->delete($this);

        return $this;
    }

    /**
     * 
     *
     * @return TableStorage
     * @throws \Exception
     */
    public function getStorage()
    {
        if (null === $this->storage) {
            throw new \Exception('storage not set');
        }

        return $this->storage;
    }
}
