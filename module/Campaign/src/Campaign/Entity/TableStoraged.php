<?php

namespace Campaign\Entity;

use App\Entity\Simple;
use App\Storage\StorageAwareInterface;
use App\Storage\Table\Simple as TableStorage;

class TableStoraged extends Simple implements StorageAwareInterface
{
    /**
     *
     * @var TableStorage
     */
    protected $storage = null;

    /**
     *
     * @param TableStorage $storage
     * @return \Application\Entity\TableStoraged
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
     * @return \Application\Entity\TableStoraged
     */
    public function save()
    {
        $this->getStorage()->save($this);

        return $this;
    }

    /**
     * 
     *
     * @return \Application\Entity\TableStoraged
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
