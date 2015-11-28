<?php

namespace Campaign\Table\TShirt;

use App\Storage\Table\Simple;
use App\Storage\Table\TableEntitySetInterface;

class Price extends Simple
{
    /**
     *
     * {@inheritdoc}
     */
    protected $fields = array(
        'sno',
        'base_price',
        'shipping_price',
        'campagin_id',
    );
}
