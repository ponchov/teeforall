<?php

namespace Campaign\Table;

use App\Storage\Table\Simple;
use App\Storage\Table\TableEntitySetInterface;

class State extends Simple
{
    /**
     *
     * {@inheritdoc}
     */
    protected $fields = array(
        'state_id',
        'state_name',
    );

    /**
     * Returns all states ordered by name
     *
     * @return TableEntitySetInterface
     */
    public function getOrderedByName()
    {
        $sql = new Sql($this->getAdapter());
        $select = $sql->select();

        $select->from($this->tableGateway->getTable());
        $select->order('state_name asc');

        return $this->tableGateway->selectWith($select);
    }
}