<?php
/*
 * all the admin functionality for handling users
 * 
 * @author Jimmy
 */
namespace Admin\Model;

use Zend\Db\TableGateway\TableGateway;

use Error\ErrorHandler;



class UsersModel
{
    protected $table_gateway;
    
    
    public function __construct(TableGateway $gateway)
    {
        // only assign the class TableGateway to $this->table_gateway
        // if $gateway is a valid instanceof TableGateway
        $this->table_gateway = $gateway instanceof TableGateway ? $gateway : null;
    }
    
    
    public function getUserIds()
    {
        return $this->table_gateway->select();
    }
    
    
    public function updateUser(array $details)
    {
        if (count($details) > 0) {
            $user_info = array();
            
            // assign the key => values in details array
            // to user_info array for consistency
            foreach ($details as $key => $value) {
                $user_info[$key] = $value;
            }
            
            try {
                // the admin should not be able to manipulate user data other than mark as active and the status
                // update ONLY this data now
                $data = array(
                    'user_status'    => $user_info['user_status'] == 0   || $user_info['user_status'] == 1
                    ? (int)$user_info['user_status']   : null,
                    
                    'active_status'  => $user_info['active_status'] == 0 || $user_info['user_status'] == 1
                    ? (int)$user_info['active_status'] : null
                );
                
                $this->table_gateway->update($data, array('id' => $this->getUserIds()->id));
                
                return true;
            } catch (\ErrorException $e) {
                // log the error message to the error file
                ErrorHandler::errorWriter($e->getMessage());
            }
        }
        
        return false;
    }
    
    
    public function removeUser(array $details, $message = false)
    {
        if (count($details) > 0) {
            $user_info = array();
            
            foreach ($details as $key => $value) {
                $user_info[$key] = $value;
            }
            
            try {
                // get the user id based on the username supplied
                $username = (!empty($user_info['username'])) ? $username : null;
                
                $select = $this->table_gateway->select(array('username' => $username));
                
                $row = $select->current();
                
                if ($row) {
                    // user id
                    $id = $row['user_id']; 
                    
                    // delete user now
                    // and send him/her a message (optional)
                    if (false !== $message) {
                        // admin would like to send the user a message
                        // about why he/she were removed
                        
                    } 
                    
                    // guess the admin didn't want to send a message
                    // go ahead and delete the user
                    $this->table_gateway->delete(array('user_id' => $row['user_id']));
                    
                    return true;
                }
            } catch (\ErrorException $e) {
                // log the error message to the error file
                ErrorHandler::errorWriter($e->getMessage());
            }
        }
    }
    
    
    public function saveCountry(array $details)
    {
        if (count($details) > 0) {
            $country_info = array();
            
            foreach ($details as $key => $value) {
                $country_info[$key] = $value;
            }
            
            try {
                // check if the country name exists first
                // pointless to overwrite an existing one
                // one should use updateCountry method instead
                $select = $this->table_gateway->select(array(''));
            } catch (\ErrorException $e) {
                // log the error message to the error file
                ErrorHandler::errorWriter($e->getMessage());
            }
        }
        
        return false;
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