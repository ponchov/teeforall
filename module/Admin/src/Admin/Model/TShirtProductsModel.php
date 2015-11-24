<?php
/*
 * handles all the t-shirt products related functionality
 * 
 * @author Jimmy
 */
namespace Admin\Model;


use Zend\Db\TableGateway\TableGateway;


class TShirtProductsModel
{
    protected $table_gateway;
    
    
    public function __construct(TableGateway $gateway)
    {
        // only assign the class TableGateway to $this->table_gateway
        // if $gateway is a valid instanceof TableGateway
        $this->table_gateway = $gateway instanceof TableGateway ? $gateway : null;
    }
    
    
    
}