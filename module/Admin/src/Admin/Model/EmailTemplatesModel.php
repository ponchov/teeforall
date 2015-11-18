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
                $data = array(
                    'email_subject' => $email_tpls->email_subject,
                    'email_body'    => $email_tpls->email_body,
                );
                
                $this->table_gateway->insert($data);
            
                return true;
            } catch (\ErrorException $e) {
                // log the message to the error file
                ErrorHandler::errorWriter($e->getMessage());
            }
        }
            
        // looks like a row was found
        // return false
        return false;
    }
    
    
    public function modifyEmailTemplate(EmailTemplates $email_tpls)
    {
        // first we need to check if the email template exist (can't update a non-existent one right ;)?)
        // if it does, update the template with the supplied values
        // if it doesn't, bail out (admin should use the saveEmailTemplate method instead)
        $select = $this->table_gateway->select(array(
            'email_subject' => $email_tpls->email_subject
        ));
        
        $row = $select->current();
        
        if (null !== $row) {
            // record was found
            // update it now
            try {
                $data = array(
                    'email_subject' => $email_tpls->email_subject,
                    'email_body'    => $email_tpls->email_body,
                );
            
                $this->table_gateway->update($data, array('id' => $row['id']));
                
                return true;
            } catch (\ErrorException $e) {
                // log the message to the error file
                ErrorHandler::errorWriter($e->getMessage());
            }
        } 
        
        // no record was found
        // return false
        return false;
    }
    
    
    public function deleteEmailTemplate(EmailTemplates $email_tpls)
    {
        // first we need to make sure the email template exists
        // before we can begin to delete it
        // if the template does exist, destroy all data (id, template_title, email_subject, email_body)
        // if the template does not exist, bail out
        $select = $this->table_gateway->select(array(
            'email_subject' => $email_tpls->email_subject,
        ));
        
        $row = $select->current();
        
        if (null !== $row) {
            // record was found
            // delete it now
            try {
                $this->table_gateway->delete(array('id' => $row['id']));
                
                return true;
            } catch (\ErrorException $e) {
                ErrorHandler::errorWriter($e->getMessage());
            }
        }
    }
}