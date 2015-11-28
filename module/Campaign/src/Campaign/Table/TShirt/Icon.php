<?php

namespace Campaign\Table\TShirt;

use App\Storage\Table\Simple;
use App\Storage\Table\TableEntitySetInterface;

class Icon extends Simple
{
    /**
     *
     * {@inheritdoc}
     */
    protected $fields = array(
        'icon',
        'title',
        'date_added',
        'status',
        'colorcode',
    );

    /**
     * Returns all live icons
     *
     * @return TableEntitySetInterface
     */
    public function getLive()
    {
        return $this->tableGateway->select(array('status' => 1));
    }
}
