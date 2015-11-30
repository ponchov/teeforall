<?php
/*
 * handles all the t-shirt size related functionality
 * 
 * @author Jimmy
 */
namespace Admin\Model;


use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Sql;


class TShirtSizeModel
{
    protected $table_gateway;
    protected $sql;
    
    
    public function __construct(TableGateway $gateway)
    {
        // only assign the class TableGateway to $this->table_gateway
        // if $gateway is a valid instanceof TableGateway
        $this->table_gateway = $gateway instanceof TableGateway ? $gateway : null;
        
        $this->sql = new Sql($this->table_gateway->getAdapter());
    }
    
    public function getOneTShirtSize($id)
    {
        $select = new Select('tshirt_size');
        
        $select->columns(array('size', 'size_inch'
        ))->where("size_id = '$id'");
        
        $adapter = $this->table_gateway->getAdapter();
         
        $query = $adapter->query($this->sql->buildSqlString($select), $adapter::QUERY_MODE_EXECUTE);
        
        $holder = array();
        
        foreach ($query as $key => $row) {
            $holder[$key] = $row;
        }
        
        return $holder;
    }
    
    
    public function listTShirtSizes()
    {
        // get all the column values 
        // then return them 
        $fetch_all = $this->table_gateway->select();
        
        return $fetch_all;
    }
    
    
    public function getTShirtSizeAvailableList()
    {
        $sql = new Sql($this->table_gateway->getAdapter());
        
        $select = new Select('tshirt_size');
        
        $select->columns(array('size'));
        
        $adapter = $this->table_gateway->getAdapter();
        
        $query = $adapter->query($sql->buildSqlString($select), $adapter::QUERY_MODE_EXECUTE);
        
        $holder = array();
        
        foreach ($query as $key => $value) {
            $holder[$key] = $value;
        }
        
        return $holder;
    }
    
    
    public function getTShirtSizeInchListAvailable()
    {
        $sql = new Sql($this->table_gateway->getAdapter());
        
        $select = new Select('tshirt_size');
        
        $select->columns(array('size_inch'));
        
        $adapter = $this->table_gateway->getAdapter();
        
        $query = $adapter->query($sql->buildSqlString($select), $adapter::QUERY_MODE_EXECUTE);
        
        $holder = array();
        
        foreach ($query as $key => $value) {
            $holder[$key] = $value;
        }
        
        return $holder;
    }
    
    
    public function addTShirtSize(TShirtSize $size)
    {
        // get the form information passed after filtered
        $data = array(
            'size'      => $size->size,
            'size_inch' => $size->size_inch,
        );
        
        // insert the data set now
        $this->table_gateway->insert($data);
        
        return true;
    }
    
    
    public function editTShirtSize(TShirtSize $size, $id)
    {
        $select = $this->table_gateway->select(array('size_id' => $id));
        
        $row = $select->current();
        
        if (null !== $row) {
            // update the tshirt size with the values from the form (after filter)
            // the update where clause is based on $id
            $data = array(
                'size'      => $size->size,
                'size_inch' => $size->size_inch,
            );
        
            $this->table_gateway->update($data, array('size_id' => $id));
        
            return true;
        }
    }
    
    
    public function deleteTShirtSize($id)
    {
        // delete the entry(s) based on what is checked
        if (!empty($id)) {
            $arr_id = explode(",", $id);
        
            foreach ($arr_id as $value) {
                $this->table_gateway->delete(array('size_id' => $value));
            }
        }
    }
}