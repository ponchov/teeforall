<?php

namespace Campaign\Entity\TShirt;

use App\Storage\StorageAwareInterface;
use App\Entity\TableStoraged;

class Discount implements StorageAwareInterface
{
    use TableStoraged;

    /**
     *
     * {@inheritdoc}
     */
    protected $keyName = 'sno';
}
