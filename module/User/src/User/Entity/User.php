<?php

namespace User\Entity;

use App\Storage\StorageAwareInterface;
use App\Entity\TableStoraged;
use App\Entity\Simple;

class User extends Simple implements StorageAwareInterface
{
    use TableStoraged;

    /**
     *
     * {@inheritdoc}
     */
    protected $keyName = 'user_id';
}