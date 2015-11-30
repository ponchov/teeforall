<?php

namespace Campaign\Entity;

use App\Storage\StorageAwareInterface;
use App\Entity\TableStoraged;

class Campaign implements StorageAwareInterface
{
    use TableStoraged;

    /**
     *
     * {@inheritdoc}
     */
    protected $keyName = 'campaign_id';
}