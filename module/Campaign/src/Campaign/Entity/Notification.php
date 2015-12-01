<?php

namespace Campaign\Entity;

use App\Storage\StorageAwareInterface;
use App\Entity\TableStoraged;
use App\Entity\Simple;

class Notification extends Simple implements StorageAwareInterface
{
    use TableStoraged;

    /**
     *
     * {@inheritdoc}
     */
    protected $keyName = 'n_id';
}