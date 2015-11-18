<?php
/*
 * Handles all the email template functions
 * 
 * @author Jimmy
 */
namespace Admin\Model;

use Zend\Db\TableGateway\TableGateway;
use Error\ErrorHandler;


class EmailTemplatesModel
{
    protected $table_gateway;
    
    public function __construct(TableGateway $gateway)
    {
        // only assign the class TableGateway to $this->table_gateway
        // if $gateway is a valid instanceof TableGateway
        $this->table_gateway = $gateway instanceof TableGateway ? $gateway : null;
    }
    
    
    public function saveEmailTemplate(EmailTemplates $email_tpls)
    {
        // first let's check if the template already exists
        // if it does, no need to overwrite it
        // one would use the modifyEmailTemplate method instead
        // this method is solely for inserting new email templates
        $select = $this->table_gateway->select(array('email_subject' => $email_tpls->email_subject));
        
        $row = $select->current();
        
        if (!$row) {
            // record was not found
            // insert the template
            try {
                $insert = $this->table_gateway->insert(array(
                    'email_subject' => $email_tpls->email_subject,
                    'email_body'    => $email_tpls->email_body,
                ));
            
                if ($insert > 0) {
                    return true;
                }
            } catch (\ErrorException $e) {
                // log the message to the error file
                ErrorHandler::errorWriter($e->getMessage());
            }
        } else {
            // looks like a row was found
            // return false
            return false;
        }
    }
}