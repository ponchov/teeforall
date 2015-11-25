<?php

namespace Admin\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Sql;


class ExportModel
{
    protected $table_gateway;
    protected $sql;
    
    
    public function __construct(TableGateway $gateway)
    {
        // only assign the class TableGateway to $this->table_gateway
        // if $gateway is a valid instanceof TableGateway
        $this->table_gateway = $gateway instanceof TableGateway ? $gateway : null;
    }
    
    
    public function tableGatewayToSql()
    {
        return new Sql($this->table_gateway->getAdapter());
    }
    
    
    public function getSuccessfulCampaign()
    {
        
    }
}