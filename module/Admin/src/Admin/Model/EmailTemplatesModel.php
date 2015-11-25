<?php
/*
 * Handles all the email template functions
 * 
 * @author Jimmy
 */
namespace Admin\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Select;

use Error\ErrorHandler;



class EmailTemplatesModel
{
    protected $table_gateway;
    protected $sql;
    
    public function __construct(TableGateway $gateway)
    {
        // only assign the class TableGateway to $this->table_gateway
        // if $gateway is a valid instanceof TableGateway
        $this->table_gateway = $gateway instanceof TableGateway ? $gateway : null;
    }
    
    
    public function getEmailTemplates()
    {
        // gets all the email templates
        //$get_all = $this->table_gateway->select();
        
        //return $get_all;
        $this->sql = new Sql($this->table_gateway->getAdapter());
        
        $select = new Select('email_templates');
        
        $select->columns(array('template_id', 'template_title', 'email_subject', 'email_body'));
        
        $adapter = $this->table_gateway->getAdapter();
       
        $query = $adapter->query($this->sql->buildSqlString($select), $adapter::QUERY_MODE_EXECUTE);
        
        $holder = array();
        
        foreach ($query as $key => $row) {
            $holder[$key] = $row;
        }
        
        return $holder;
    }
    
    public function getEmailTemplate($id)
    {
        // get one email template
        $get_one = $this->table_gateway->select(array('id' => $id));
        
        $row = $get_one->current();
        
        if ($row) {
            return $row;
        }
        
        return false;
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
    
    
    public function modifyEmailTemplate(EmailTemplates $email_tpls, $id)
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
            
                $this->table_gateway->update($data, array('id' => (int)$id));
                
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
    
    
    public function deleteEmailTemplate(EmailTemplates $email_tpls, $id)
    {
        // first we need to make sure the email template exists
        // before we can begin to delete it
        // if the template does exist, destroy all data (id, template_title, email_subject, email_body)
        // if the template does not exist, bail out
        $select = $this->table_gateway->select()->where(array('template_id' => $id));
        
        try {
            foreach ($select as $value) {
                $this->table_gateway->delete(array('id' => $value->id));
            }
        } catch (\ErrorException $e) {
            ErrorHandler::errorWriter($e->getMessage());
        }
    }
}