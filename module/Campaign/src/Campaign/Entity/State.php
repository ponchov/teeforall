<?php

namespace Campaign\Entity;

use App\Storage\StorageAwareInterface;
use App\Entity\TableStoraged;

class State implements StorageAwareInterface
{
    use TableStoraged;

    /**
     *
     * {@inheritdoc}
     */
    protected $keyName = 'state_id';
}