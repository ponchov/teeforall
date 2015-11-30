<?php

namespace Campaign\Entity\TShirt;

use App\Storage\StorageAwareInterface;
use App\Entity\TableStoraged;

class Product implements StorageAwareInterface
{
    use TableStoraged;

    /**
     *
     * {@inheritdoc}
     */
    protected $keyName = 't_cat_id';
}
