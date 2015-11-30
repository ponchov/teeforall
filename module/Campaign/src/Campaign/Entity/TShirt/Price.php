<?php

namespace Campaign\Entity\TShirt;

use App\Storage\StorageAwareInterface;
use App\Entity\TableStoraged;

class Price implements StorageAwareInterface
{
    use TableStoraged;

    /**
     *
     * {@inheritdoc}
     */
    protected $keyName = 'sno';
}
