<?php
/*
 * @author Jimmy
 * 
 * Class that holds all the admin functionality for use by the admin
 */
namespace Admin\Model;

use Zend\Log\Logger;
use Zend\Log\Writer\Stream;

use Zend\Db\TableGateway\TableGateway;

use Error\ErrorHandler;


class AdminModel
{
    protected $table_gateway;
    
    
    
    public function __construct(TableGateway $gateway)
    {
        // only assign the class TableGateway to $this->table_gateway
        // if $gateway is a valid instanceof TableGateway
        $this->table_gateway = $gateway instanceof TableGateway ? $gateway : null;    
    }
    
    
    public function handleConfiguration(Configuration $config)
    {
        $fields = array(
           'site_title'        => $config->site_title,
           'site_description'  => $config->site_description,
           'site_keywords'     => $config->site_keywords,
           'admin_email'       => $config->admin_email,
        );
        
        try {
            
        } catch (\ErrorException $e) {
            // log the message to the error file
            $writer = new Stream(ErrorHandler::ERROR_PATH);
            $logger = new Logger();
            $logger->addWriter($writer);
             
            $logger->info($e->getMessage() . "\r\r");
             
            return false;
        }
    }
}