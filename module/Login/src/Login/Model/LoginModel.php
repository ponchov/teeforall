<?php
/*
 * @author Jimmy
 * 
 * This file handles the login attempt by the admin
 */

namespace Login\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Insert;
use Zend\Db\Sql\Delete;


class LoginModel 
{
	protected $table_gateway;
	protected $sql;
	
	
	public function __construct(TableGateway $gateway)
	{
		$this->table_gateway = $gateway;	
		$this->sql = new Sql($this->table_gateway->getAdapter());
	}
	
	
	public function getUser(array $info)
	{
		$username = (!empty($info['username'])) ? $info['username'] : null;
		$password = (!empty($info['password'])) ? $info['password'] : null;
		
		
		$rowset = $this->table_gateway->select(array('username' => $username,
		    'password' => $password));
		
		$row = $rowset->current();
		
		if (!$row) {
			throw new \Exception("Invalid login credentials");
		}
		
		return $row;
	}
	
	
	public function checkSession($username)
	{
		$adapter = $this->sql->getAdapter()->getDriver()->getConnection();
		
		$query = $adapter->execute("SELECT active AS active_user
		    FROM sessions WHERE username = '$username'");
		
		foreach ($query as $row) {
			if ($row['active_user'] == 1) {
				return false;
			}
		}
		
		return true;
	}
	
	
	public function insertSession($username, $password, $session_id)
	{
		$insert = new Insert('sessions');
		
		$adapter = $this->table_gateway->getAdapter();
		
		$insert->columns(array('username', 'password', 'active', 'session_id'))
			   ->values(array('username' => $username, 'password' => $password,
			       'active' => 1, 'session_id' => $session_id));
		
		$adapter->query(
			$this->sql->getSqlStringForSqlObject($insert),
			$adapter::QUERY_MODE_EXECUTE
		);
		
		return true;
	}
	
	
	public function deleteSession($username)
	{
		$delete = new Delete();
		
		$adapter = $this->table_gateway->getAdapter();
		
		$delete->from('sessions')
		->where(array('username' => $username, 'session_id' => session_id()));
		
		$adapter->query(
			$this->sql->getSqlStringForSqlObject($delete),
			$adapter::QUERY_MODE_EXECUTE
		);
		
		return true;
	}
}
