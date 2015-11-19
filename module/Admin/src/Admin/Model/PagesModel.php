<?php
/*
 * Handles all the page functions
 *
 * @author Jimmy
 */
namespace Admin\Model;

use Zend\Db\TableGateway\TableGateway;


class PagesModel
{
    protected $table_gateway;
    
    public function __construct(TableGateway $gateway) {
        // only assign the class TableGateway to $this->table_gateway
        // if $gateway is a valid instanceof TableGateway
        $this->table_gateway = $gateway instanceof TableGateway ? $gateway : null;
    }
    
    
    public function getPages()
    {
        $get_all = $this->table_gateway->select();
        
        return $get_all;
    }
    
    
    public function savePage() 
    {
        
    }
    
    
    public function updatePage()
    {
        
    }
    
    
    public function updateCategory()
    {
        
    }
    
    
    public function updateTestimonals()
    {
        
    }
    
    
    public function updateQuestion()
    {
        
    }
    
    
    public function saveCategory()
    {
        
    }
    
    
    public function saveTestimonals()
    {
        
    }
    
    
    public function saveQuestion()
    {
        
    }
    
    
    
}

