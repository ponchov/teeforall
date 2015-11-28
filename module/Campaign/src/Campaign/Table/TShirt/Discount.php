<?php

namespace Campaign\Table\TShirt;

use App\Storage\Table\Simple;
use App\Storage\Table\TableEntitySetInterface;

class Discount extends Simple
{
    /**
     *
     * {@inheritdoc}
     */
    protected $fields = array(
        'sno',
        'no_of_tee',
        'discount_per',
    );
}
