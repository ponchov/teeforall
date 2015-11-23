<?php
/*
 * all the admin functionality for handling users
 * 
 * @author Jimmy
 */
namespace Admin\Model;

use Zend\Db\TableGateway\TableGateway;


class UsersModel
{
    protected $table_gateway;
    
    
    public function __construct(TableGateway $gateway)
    {
        $this->table_gateway = $gateway instanceof TableGateway ? $gateway : null;
    }
    
    
    public function updateUser(array $details)
    {
        
    }
    
    
    public function saveCountry(array $details)
    {
        
    }
    
    
    public function updateCountry(array $details)
    {
        
    }
    
    
    public function updateState(array $details)
    {
        
    }
    
    
    public function updateCity(array $details)
    {
        
    }
    
    
    public function saveState(array $details)
    {
        
    }
    
    
    public function saveCity(array $details)
    {
        
    }
    
    
    
}