<?php
/*
 * model class to handle all campaign related functionality
 * 
 * @author Jimmy
 */
namespace Admin\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Sql;


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
    
    
    
}