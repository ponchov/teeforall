<?php

namespace Campaign\Table\TShirt;

use App\Storage\Table\Simple;
use App\Storage\Table\TableEntitySetInterface;

class Size extends Simple
{
    /**
     *
     * {@inheritdoc}
     */
    protected $fields = array(
        'sizeid',
        'material',
        'size',
        'size_inch',
    );
}
