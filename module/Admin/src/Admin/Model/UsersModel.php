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
use Zend\Db\Sql\Sql;

use Error\ErrorHandler;
use Zend\Db\Sql\Select;



class UsersModel
{
    protected $table_gateway;
    protected $sql;
    
    
    public function __construct(TableGateway $gateway)
    {
        // only assign the class TableGateway to $this->table_gateway
        // if $gateway is a valid instanceof TableGateway
        $this->table_gateway = $gateway instanceof TableGateway ? $gateway : null;
        
        $this->sql = new Sql($this->table_gateway->getAdapter());
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
    
    
    public function getUsersToContact()
    {
        $adapter = $this->sql->getAdapter()->getDriver()->getConnection();
        
        $query = $adapter->execute("SELECT DISTINCT u.* FROM users u INNER JOIN launchcampaign
            ON launchcampaign.user_id = u.user_id");
        
        $holder = array();
        
        foreach ($query as $rows) {
            $holder = $rows;
        }
        
        return $holder;
    }
    
    
    public function getBuyersToContact() 
    {
        $select = new Select('buyers');
        
        $select->columns(array('id, user_id, email, name'));
        
        $string = $this->sql->buildSqlString($select);
        
        $adapter = $this->table_gateway->getAdapter();
         
        $rowset = $adapter->query($string, $adapter::QUERY_MODE_EXECUTE);
        
        if (count($rowset) > 0) {
            $holder = array();
            
            foreach ($rowset as $rows) {
                $holder = array_merge($rows->id, $rows->user_id, $rows->email, $rows->name);
            }
            
            return $holder;
        }
    }
    
    
    public function sendMailtoUsers(array $params)
    {
        if (!empty($params['allusers'])) {
            // get all users to email
            $select = $this->table_gateway->select();
            
            $users = array();
            
            foreach ($select as $rows) {
                $temp = array();
                
                $user_id  = $rows->user_id;
                $temp['email'] = $rows->username;
                $temp['name'] = $rows->public_name;
                
                $users[] = $temp;
            }
        } else {
            if (!empty($params['rightValues'])) {
                for ($i=0; $i<count($params['rightValues']); $i++) {
                    $str = explode("::", $params['rightValues'][$i]);
                    $temp = array();
                    $temp['email'] = $str[0];
                    $temp['name'] = $str[1];
                    
                    $users[] = $temp;
                }
            }
        }
        
        // send the emails now
        $tpl_table = new Select('email_templates');
        
        $tpl_table->columns(array('template_id', 'template_title', 'email_subject', 'email_body'))
        ->where('template_id = 20');
        
        $string = $this->sql->buildSqlString($tpl_table);
        
        $adapter = $this->table_gateway->getAdapter();
        
        $rowset = $adapter->query($string, $adapter::QUERY_MODE_EXECUTE);
        
        if (count($rowset) > 0) {
            $holder = array();
            
            foreach ($rowset as $rows) {
                $holder = $rows;
            }
            
            $msg_text = $holder->email_body;
            $subject  = $holder->email_subject;
            
            $msg_text = str_replace("[SITENAME]", "my site", $msg_text);
            $msg_text = str_replace("[SITEURL]", "http://" . $_SERVER['SERVER_NAME'] . "/", $msg_text);
            
            foreach ($users as $user) {
                if (!empty($user['name'])) {
                    $message = str_replace("[NAME]", $user['name'], $msg_text);  
                } else {
                    $message = str_replace("[NAME]", $user['email'], $msg_text);
                }
                
                
                // make the content html and not text
                $mime = new Mime\Part($message);
                $mime->type = "text/html";
                
                $mime_msg = new Mime\Message();
                $mime_msg->setParts(array($mime));
                
                $mail = new Mail\Message();
                
                $mail->addFrom($message)
                ->addTo($user['email']) // username is the email address
                ->setSubject($holder->subject)
                ->setBody($mime_msg);
                
                // send the email now
                $send = new Mail\Transport\Sendmail();
                
                $send->send($mail);
            }
        }
    }
    
    
    public function sendMailToBuyers(array $params)
    {
        if (!empty($params['allusers'])) {
            // get all users to email
            $select = new Select('buyers');
        
            $select->columns(array('id, user_id, email, name'));
            
            $string = $this->sql->buildSqlString($select);
            
            $adapter = $this->table_gateway->getAdapter();
             
            $rowset = $adapter->query($string, $adapter::QUERY_MODE_EXECUTE);
            
            $holder = array();
            
            foreach ($rowset as $rows) {
                $temp = array();
        
                $user_id  = $rows->user_id;
                $temp['email'] = $rows->email;
                $temp['name'] = $rows->name;
        
                $users[] = $temp;
            }
        } else {
            if (!empty($params['rightValues'])) {
                for ($i=0; $i<count($params['rightValues']); $i++) {
                    $str = explode("::", $params['rightValues'][$i]);
                    $temp = array();
                    $temp['email'] = $str[0];
                    $temp['name'] = $str[2];
        
                    $users[] = $temp;
                }
            }
        }
        
        // send the emails now
        $tpl_table = new Select('email_templates');
        
        $tpl_table->columns(array('template_id', 'template_title', 'email_subject', 'email_body'))
        ->where('template_id = 21');
        
        $string = $this->sql->buildSqlString($tpl_table);
        
        $adapter = $this->table_gateway->getAdapter();
        
        $rowset = $adapter->query($string, $adapter::QUERY_MODE_EXECUTE);
        
        if (count($rowset) > 0) {
            $holder = array();
        
            foreach ($rowset as $rows) {
                $holder = $rows;
            }
        
            $msg_text = $holder->email_body;
            $subject  = $holder->email_subject;
        
            $msg_text = str_replace("[SITENAME]", "my site", $msg_text);
            $msg_text = str_replace("[SITEURL]", "http://" . $_SERVER['SERVER_NAME'] . "/", $msg_text);
        
            foreach ($users as $user) {
                if (!empty($user['name'])) {
                    $message = str_replace("[NAME]", $user['name'], $msg_text);
                } else {
                    $message = str_replace("[NAME]", $user['email'], $msg_text);
                }
        
        
                // make the content html and not text
                $mime = new Mime\Part($message);
                $mime->type = "text/html";
        
                $mime_msg = new Mime\Message();
                $mime_msg->setParts(array($mime));
        
                $mail = new Mail\Message();
        
                $mail->addFrom($message)
                ->addTo($user['email']) // username is the email address
                ->setSubject($holder->subject)
                ->setBody($mime_msg);
        
                // send the email now
                $send = new Mail\Transport\Sendmail();
        
                $send->send($mail);
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