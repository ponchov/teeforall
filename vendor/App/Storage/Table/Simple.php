<?php

namespace App\Storage\Table;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Predicate;

use App\Storage\StorageAwareInterface;
use App\Entity\EntityInterface;

class Simple
{
    /**
     *
     * @var TableGateway
     */
    protected $tableGateway = null;

    /**
     * The list of valid fields in table
     *
     * @var array
     */
    protected $fields = array();

    /**
     *
     * @param \Zend\Db\TableGateway\TableGateway $tableGateway
     */
    public function __construct(TableGateway $tableGateway, array $fields = array())
    {
        $this->tableGateway = $tableGateway;

        $itemSetProto = $this->tableGateway->getResultSetPrototype();
        if (!$itemSetProto instanceof TableEntitySetInterface) {
            throw new \Exception('ResultSetPrototype must implement TableEntitySetInterface');
        }

        if ($itemSetProto instanceof StorageAwareInterface) {
            $itemSetProto->setStorage($this);
        }

        if (!empty($fields)) {
            $this->setFields($fields);
        }
    }

    /**
     *
     * @return TableEntitySetInterface
     */
    public function getItemSetProto()
    {
        return $this->tableGateway->getResultSetPrototype();
    }

    /**
     * Creates new EntitySet based on prototype
     *
     * @param mixed $data
     * @return TableEntitySetInterface
     */
    public function createItemSet($data = null)
    {
        $itemSet = clone $this->getItemSetProto();
        if (null !== $data) {
            $itemSet->initialize($data);
        }

        return $itemSet;
    }

    /**
     *
     * @param array $fields
     * @return \App\Storage\Table\Simple
     */
    public function setFields(array $fields)
    {
        $this->fields = $fields;

        return $this;
    }

    /**
     *
     * @return array
     */
    public function getFields()
    {
        return $this->fields;
    }

    /**
     * Returns Entity by its key value
     *
     * @param string|integer $id
     * @return mixed
     * @throws \Exception
     */
    public function getByKey($id)
    {
        $rowset = $this->tableGateway->select(
            array(
                $this->getItemSetProto()->getFactory()->getEntityProto()->getKeyName() => $id
            )
        );
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $id");
        }

        return $row;
    }

    /**
     * Returns EntitySet defined by $start and $stop range of key
     *
     * @param integer $start
     * @param integer $stop
     * @return TableEntitySetInterface
     */
    public function getRangeByKey($start, $stop)
    {
        $sql = new Sql($this->getAdapter());
        $select = $sql->select();

        $select->from($this->tableGateway->getTable());
        $select->where(
            new Predicate\Between(
                $this->getItemSetProto()->getFactory()->getEntityProto()->getKeyName(),
                $start,
                $stop
            )
        );

        return $this->tableGateway->selectWith($select);
    }

    /**
     * Return all Entities from storage
     * 
     * @return TableEntitySetInterface
     */
    public function getAll()
    {
        return $this->tableGateway->select();
    }

    /**
     * Saves the Entity into storage
     *
     * @param EntityInterface $object
     * @throws \Exception
     */
    public function save(EntityInterface $object)
    {
        $data = array();
        foreach ($this->fields as $field) {
            $data[$field] = $object->{$field};
        }

        $id = $object->getKeyValue();
        if (null === $id) {
            $this->tableGateway->insert($data);
            $object->{$object->getKeyName()} = $this->tableGateway->getLastInsertValue();
        } else {
            if ($this->getByKey($id, $object->getKeyName())) {
                $this->tableGateway->update($data, array($object->getKeyName() => $id));
            } else {
                throw new \Exception('row with ' . $id . ' id does not exist');
            }
        }
    }

    /**
     * Removes Entity from storage
     *
     * @param string|integer|EntityInterface $id
     * @return \App\Storage\Table\Simple
     */
    public function delete($id)
    {
        if ($id instanceof EntityInterface) {
            $id = $id->getKeyValue();
        }

        $this->tableGateway->delete(
            array(
                $this->getItemSetProto()->getFactory()->getEntityProto()->getKeyName() => $id
            )
        );

        return $this;
    }

    /**
     *
     * @return Adapter
     */
    public function getAdapter()
    {
        return $this->tableGateway->getAdapter();
    }
}
