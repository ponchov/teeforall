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
    
    
    // gets a list of all the users in the users table
    public function getAllUsers()
    {
        $get_all = $this->table_gateway->select();
        
        return $get_all;
    }
    
    
    // gets a list of one user in user table based on id
    public function getUser($id) 
    {
        $this->sql = new Sql($this->table_gateway->getAdapter());
        
        $select = new Select('users');
        
        $select->columns(array('username', 'password', 'first_name', 'last_name',
            'gender', 'address', 'city', 'state', 'zipcode', 'country'
        ))->where("user_id = '$id'");
        
        $adapter = $this->table_gateway->getAdapter();
       
        $query = $adapter->query($this->sql->buildSqlString($select), $adapter::QUERY_MODE_EXECUTE);
        
        $holder = array();
        
        foreach ($query as $key => $row) {
            $holder[$key] = $row;
        }
        
        return $holder;
    }
      
    /*
     * forget this stupid method >:(
     */
    public function updateUserStatus(array $details)
    {
        if (count($details) > 0) {
            $user_info = array();
            
            // assign the key => values in details array
            // to user_info array for consistency
            foreach ($details as $key => $value) {
                $user_info[$key] = $value;
            }
            
            try {
                $data = array(
                    'user_status' => $user_info['user_status'] == 1 ? 0 : 1,
                );
                
                $this->table_gateway->update($data, array('user_id' => $user_info['user_id']));
                
                return true;
            } catch (\ErrorException $e) {
                // log the error message to the error file
                ErrorHandler::errorWriter($e->getMessage());
            }
        }
        
        return false;
    }
    
    
    // removes a user from the users table
    public function removeUser($id)
    {
        // delete the entry(s) based on what is checked
        if (!empty($id)) {
            $arr_id = explode(",", $id);
        
            foreach ($arr_id as $value) {
                $this->table_gateway->delete(array('user_id' => $value));
            }
        }
    }
    
    
    // adds a user to the database
    public function addUser(Users $users)
    {
        $fields = array(
            'username'   => $users->username,
            'password'   => hash('sha512', $users->password),
            'first_name' => $users->first_name,
            'last_name'  => $users->last_name,
            'gender'     => $users->gender,
            'address'    => $users->address,
            'city'       => $users->city,
            'state'      => $users->state,
            'zipcode'    => $users->zipcode,
            'country'    => $users->country,
        );
        
        
        try {
            if ($this->table_gateway->insert($fields) > 0) {
                return true;
            }
        } catch (\ErrorException $e) {
            // log the message to the error file
            ErrorHandler::errorWriter($e->getMessage());
        }
    }
    
    
    // edits a user info 
    public function editUser(Users $users, $id)
    {
        // get the user information based on the id passed
        $select = $this->table_gateway->select(array('user_id' => $id));
        
        $row = $select->current();
        
        if (null !== $row) {
            // record found
            // update the info now
            $data = array(
                'username'   => $users->username,
                'password'   => hash('sha512', $users->password),
                'first_name' => $users->first_name,
                'last_name'  => $users->last_name,
                'gender'     => $users->gender,
                'address'    => $users->address,
                'city'       => $users->city,
                'state'      => $users->state,
                'zipcode'    => $users->zipcode,
                'country'    => html_entity_decode($users->country),
            );
            
            $this->table_gateway->update($data, array('user_id' => $id));
            
            return true;
        }
    }
    
    
    public function listCountries()
    {
        $select = new Select('countries');
        
        $select->columns(array('country_id', 'country_name'));
        
        $adapter = $this->table_gateway->getAdapter();
        
        $query = $adapter->query($this->sql->buildSqlString($select), $adapter::QUERY_MODE_EXECUTE);
        
        $holder = array();
        
        foreach ($query as $key => $value) {
            $holder[$key] = $value;
        }
        
        return $holder;
    }
    
    
    // gets a list of users to contact
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
    
    
    // gets a list of buyers to contact
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
    
    // sends the email to the users selected
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
    
    
    // sends the email to the buyers selected
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
    
    

}
    
    
   