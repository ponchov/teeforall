<?php

namespace Campaign\Table\TShirt;

use Zend\Db\Sql;

use App\Storage\Table\Simple;
use App\Storage\Table\TableEntitySetInterface;

class Product extends Simple
{
    /**
     *
     * {@inheritdoc}
     */
    protected $fields = array(
        't_cat_id',
        't_sort',
        'name',
        'date_added',
        'status',
        'image',
        'backimage',
        'totalimage',
        'frontShadow',
        'frontHeigh',
        'backHeigh',
        'backShadow',
        'colorcode',
    );

    /**
     * Returns all live products
     *
     * @return TableEntitySetInterface
     */
    public function getLive()
    {
        $sql = new Sql\Sql($this->getAdapter());
        $select = $sql->select();

        $select->from($this->tableGateway->getTable());
        $select->where(array('status' => 1));
        $select->order('t_sort asc');

        return $this->tableGateway->selectWith($select);
    }
}
