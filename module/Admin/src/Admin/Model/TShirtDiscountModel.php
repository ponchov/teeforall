<?php
/*
 * handles all the t-shirt discount related functionality
 * 
 * @author Jimmy
 */
namespace Admin\Model;


use Zend\Db\TableGateway\TableGateway;


class TShirtDiscountModel
{
    protected $table_gateway;
    
    
    public function __construct(TableGateway $gateway)
    {
        // only assign the class TableGateway to $this->table_gateway
        // if $gateway is a valid instanceof TableGateway
        $this->table_gateway = $gateway instanceof TableGateway ? $gateway : null;
    }
    
    
    
}