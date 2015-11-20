<?php
/*
 * Handles all the category functions
 *
 * @author Jimmy
 */

namespace Admin\Model;

use Zend\Db\TableGateway\TableGateway;

use Error\ErrorHandler;


class CategoriesModel 
{
    protected $table_gateway;
    
    public function __construct(TableGateway $gateway)
    {
        // only assign the class TableGateway to $this->table_gateway
        // if $gateway is a valid instanceof TableGateway
        $this->table_gateway = $gateway instanceof TableGateway ? $gateway : null;
    }
    
    
    public function listCategories()
    {
        // get all the categories from the database
        $get_all = $this->table_gateway->select();
        
        return $get_all;
    }
    
    
    public function updateCategory()
    {
        
    }
    
    
    public function saveCategory()
    {
    
    }
}