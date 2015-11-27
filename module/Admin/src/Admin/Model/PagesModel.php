<?php
/*
 * Handles all the page functions
 *
 * @author Jimmy
 */
namespace Admin\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Select;


use Error\ErrorHandler;


class PagesModel
{
    protected $table_gateway;
    
    public function __construct(TableGateway $gateway)
    {
        // only assign the class TableGateway to $this->table_gateway
        // if $gateway is a valid instanceof TableGateway
        $this->table_gateway = $gateway instanceof TableGateway ? $gateway : null;
    }
    
    
    public function getPages()
    {
        // get all pages 
        $this->sql = new Sql($this->table_gateway->getAdapter());
        
        $select = new Select('pages');
        
        $select->columns(array('page_id', 'page_title', 'page_content', 'page'));
        
        $adapter = $this->table_gateway->getAdapter();
       
        $query = $adapter->query($this->sql->buildSqlString($select), $adapter::QUERY_MODE_EXECUTE);
        
        $holder = array();
        
        foreach ($query as $key => $row) {
            $holder[$key] = $row;
        }
        
        return $holder;
    }
    
   
    public function getPage($id)
    {
        // gets one page based on the id passed
        $get = $this->table_gateway->select(array('id' => $id));
        
        $row = $get->current();
        
        if ($row) {
            return $row;
        }
        
        return false;
    }
    
    
    public function savePage(Pages $pages) 
    {
        // first make sure the page doesn't exist
        // don't want to overwrite a page
        // admin should user updatePage instead
        $get_page = $this->table_gateway->select(array('page_title' => $pages->page_title));
        
        $row = $get_page->current();
        
        if (!$row) {
            // page not found
            // proceed to save the page
            $data = array(
                'page_title'    => $pages->page_title,
                'page_content'  => $pages->page_content
            );
            
            $insert = $this->table_gateway->insert($data);
            
            if ($insert > 0) {
                return true;
            }
        }
        
        return false;
    }
    
    
    public function updatePage(Pages $pages, $id)
    {
        try {
            // update the page with the values from the forms (after filter)
            // the update where clause is based on $id
            $data = array(
                'page_title'   => $pages->page_title,
                'page_content' => $pages->page_content,
            );
        
            $this->table_gateway->update($data, array('id' => (int)$id));
            
            return true;
        } catch (\ErrorException $e) {
            // log the message to the error file
            ErrorHandler::errorWriter($e->getMessage());
        }
    }
    
    
    public function deletePage($id)
    {
        try {
            // remove the page from the database based on $id
            $this->table_gateway->delete(array('id' => (int)$id));
            
            return true;
        } catch (\ErrorException $e) {
            // log the message to the error file
            ErrorHandler::errorWriter($e->getMessage());
        }
    }
   
}

