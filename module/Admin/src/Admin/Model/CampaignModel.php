<?php
/*
 * model class to handle all campaign related functionality
 * 
 * @author Jimmy
 */
namespace Admin\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Sql;

use Zend\Mail;
use Zend\Mime;


class CampaignModel
{
    protected $table_gateway;
    protected $sql;
    
    
    public function __construct(TableGateway $gateway)
    {
        // only assign the class TableGateway to $this->table_gateway
        // if $gateway is a valid instanceof TableGateway
        $this->table_gateway = $gateway instanceof TableGateway ? $gateway : null;
        
        // some functionality cannot be achieved with TableGateway
        // in this case, we will use the Sql class to achieve the 
        // desired functionality
        $this->sql = new Sql($this->table_gateway->getAdapter());
    }
    
    
    public function getCampaigns()
    {
        // display in an array all the campaigns 
        // with a draft status of 1
        $select = $this->table_gateway->select(array('draft_status' => 1));
        
        return $select;
    }
    
    
    public function getLiveCampaigns()
    {
        // this method will retrieve all the live campaigns
        // from the launch campaigns table
        // based on the condition the the time limit in days has not expired
        $adapter = $this->sql->getAdapter()->getDriver()->getConnection();
        
        $query = $adapter->execute("SELECT *, date_add(launch_date, INTERVAL campaign_length DAY)
            AS endData FROM launchcampaign WHERE (campaign_status = 1 AND draft_status = 1)
            AND date_add(launch_date, INTERVAL campaign_length DAY) >= CURDATE()
            ORDER BY endData DESC");
        
        return $query;
    }
   
    
    public function campaignSuccess()
    {
        // retrieve a successful campaign
        // based on either if the goal was met 
        // or the goal was exceeded
        $adapter = $this->sql->getAdapter()->getDriver()->getConnection();
        
        $query = $adapter->execute("SELECT launchcampaign.*, users.first_name AS fname,
            users.last_name AS lname, 
            ( SELECT SUM(preapprovals_share_user FROM preapprovals WHERE preapprovals_campaign = 
              launchcampaign.campaign_id AND preapprovals_status = 'collected') AS ushare,
            
              ( SELECT sum(preapprovals_qty) FROM preapprovals WHERE prepprovals_campaign = 
                 launchcampaign.campaign_id AND preapprovals_status != 'collected') AS ucancelled
            FROM launchcampaign LEFT JOIN users ON users.user_id = launchcampaign.user_id
            WHERE launchcampaign.goal = launchcampaign.sold OR launchcampaign.sold > launchcampaign.goal)
            AND launchcampaign.goal <> 0");
        
        return $query;
    }
    
    
    public function getProfitDetails($id)
    {
        // get the title for the launched campaign
        // to enter the profit for it
        $select = $this->table_gateway->select(array('campaign_id' => $id));
        
        $row = $select->current();
        
        if (!$row) {
            $holder = array();
            
            foreach ($row as $value) {
                $holder = $value;
            }
            
            return $holder->title;
        }
    }
    
    
    public function saveProfit(Campaign $campaign, $id)
    {
        // save the user supplied profit information
        if (!empty($campaign->profit)) {
            // profit was not empty
            // check if it is a float type
            // it should be but to put my mind at ease just check
            if (is_float($campaign->profit)) {
                $data = array(
                    'profit' => $campaign->profit,  
                );
                
                $this->table_gateway->update($data, array('campaign_id' => $id));
                
                return true;
            } else {
                return false;
            }
        }
        
        return false;
    }
    
    
    public function emailFriends(Campaign $campaign)
    {
        // this method gets all the friends email addresses tied to a campaign
        // and sends out an email to each one
        $friends_email_address = explode(",", $campaign->friends_email_address);
        
        $mime = new Mime\Part($campaign->content);
        $mime->type = "text/html";
        
        $mime_msg = new Mime\Message();
        $mime_msg->setParts(array($mime));
        
        $mail = new Mail\Message();
        
        $send = new Mail\Transport\Sendmail();
        
        for ($i=0; $i<count($friends_email_address); $i++) {
            $mail->addTo($friends_email_address[$i])
            ->setSubject($campaign->subject)
            ->setBody($campaign->content);
            
            $send->send($mail);
        }
        
        return true;
    }
}