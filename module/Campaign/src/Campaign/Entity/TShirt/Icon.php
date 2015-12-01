<?php

namespace Campaign\Entity\TShirt;

use App\Storage\StorageAwareInterface;
use App\Entity\TableStoraged;
use App\Entity\Simple;

class Icon extends Simple implements StorageAwareInterface
{
    use TableStoraged;
}
