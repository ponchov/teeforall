<?php
/*
 * this class gets the categories and the questions
 * in one place, so it's not scattered all over the place
 * 
 * @author - Jimmy
 * 
 * please don't edit this file
 * 
 */
namespace Categories;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Select;



class Categories 
{
    protected $category_id;
    protected $table_gateway;
    
    
    public function __construct(TableGateway $gateway, $category_id)
    {
        $this->table_gateway = $gateway instanceof TableGateway ? $gateway : null;
        
        $this->category_id = (!empty($category_id)) ? (int)$category_id : null;    
    }
    
    
    public function getQuestion()
    {
        $get = $this->table_gateway->select(array('cat_id' => $this->category_id));
        
        $row = $get->current();
        
        if ($row) {
            return $row;
        }
        
        return false;
    }
    
    
    public function getQuestions($table = 'questions')
    {
        $sql = new Sql($this->table_gateway->getAdapter());
        
        if ($sql instanceof Sql) {
            $select = new Select($table);
            
            $query = $select->columns(array('question_id', 'cat_id', 'question', 'answer'));
            
            $adapter = $this->table_gateway->getAdapter();
            
            $rowset = $adapter->query($sql->buildSqlString($select), $adapter::QUERY_MODE_EXECUTE);
            
            if (count($rowset) > 0) {
                foreach ($rowset as $value) {
                    $row_holder = $value;
                }
                
                return $row_holder;
            }
        }
        
        return false;
    }
    
    
    
}