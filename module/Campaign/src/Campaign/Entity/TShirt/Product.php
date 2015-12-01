<?php

namespace Campaign\Entity\TShirt;

use App\Storage\StorageAwareInterface;
use App\Entity\TableStoraged;
use App\Entity\Simple;

class Product extends Simple implements StorageAwareInterface
{
    use TableStoraged;

    /**
     *
     * {@inheritdoc}
     */
    protected $keyName = 't_cat_id';
}
