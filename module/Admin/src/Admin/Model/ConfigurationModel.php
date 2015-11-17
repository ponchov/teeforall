<?php
/*
 * model specific to handling system configuration
 * 
 * @author Jimmy
 */
namespace Admin\Model;

use Zend\Db\TableGateway\TableGateway;

use Error\ErrorHandler;


class ConfigurationModel
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
            if ($this->table_gateway->insert(array($fields)) > 0) {
                return true;
            }
        } catch (\ErrorException $e) {
            // log the message to the error file
            ErrorHandler::errorWriter($e->getMessage());
        }
    }
}