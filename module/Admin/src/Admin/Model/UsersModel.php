<?php
/*
 * all the admin functionality for handling users
 * 
 * @author Jimmy
 */
namespace Admin\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Mail;
use Zend\Mime;

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
    
    
    public function getAllUsers()
    {
        $get_all = $this->table_gateway->select();
        
        return $get_all;
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
                // the admin should not be able to manipulate user data other than status update
                // update ONLY this data now
                $data = array(
                    'user_status' => $user_info['user_status']
                );
                
                $this->table_gateway->update($data, array('id' => $user_info['user_id']));
                
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
                // get the user id based on the id supplied
                $user_id = (!empty($user_info['user_id'])) ? $user_info['user_id'] : null;
                
                $select = $this->table_gateway->select(array('user_id' => $user_id));
                
                $row = $select->current();
                
                if ($row) {
                    // user id
                    $id = $row['user_id']; 
                    
                    // delete user now
                    // and send him/her a message (optional)
                    if (false !== $message) {
                        // admin would like to send the user a message
                        // about why he/she were removed
                        $sorry = <<<MESSAGE
                            We're sorry, but your account was removed. If you would like to know more, 
                            please contact us and we will be glad to help resolve any issues.
                        <br>
                        Thank You,
                        <br>
                        TeeForAll.com
MESSAGE;
                       
                        // make the content html and not text
                        $mime = new Mime\Part($sorry);
                        $mime->type = "text/html";
                                
                        $mime_msg = new Mime\Message();
                        $mime_msg->setParts(array($mime));
                        
                        $mail = new Mail\Message();
                        
                        $mail->addFrom("support@teeforall.com")
                             ->addTo($row['username']) // username is the email address
                             ->setSubject("Removal of account with TeeForAll.com")
                             ->setBody($mime_msg);
                        
                        // send the email now
                        $send = new Mail\Transport\Sendmail();
                        
                        $send->send($mail);
                        
                        $this->table_gateway->delete(array('user_id' => $row['user_id']));
                        
                        return true;
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
    
    /* 
     * honestly I don't think these methods should be in the admin panel 
     * they should be in the user panel
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
        
    } */
}