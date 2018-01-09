<?php

namespace Melipayamak;


class Contacts
{
	
	protected $username;
	
	protected $password;
	
	protected $client;
	
	const PATH = 'http://api.payamak-panel.com/post/contacts.asmx?wsdl';
	
	public function __construct($username,$password)
	{
		
		
		if (is_null($username)||is_null($password)) {
			
			die('username/password is empty');
			
			exit;
			
		}
		
		ini_set("soap.wsdl_cache_enabled", "0");
		
		$this->username = $username;
		
		$this->password = $password;
		
		$this->client = new \SoapClient(self::PATH);
		
	}
	
	public function addGroup($groupName,$Descriptions,$showToChilds)
	{
		
		$result = $this->client->AddGroup([
		'username'=> $this->username,
		'password' => $this->password,
		'groupName'=> $groupName,
		'Descriptions'=> $Descriptions,
		'showToChilds'=> $showToChilds
		])->AddGroupResult;
		
		return $result;
		
	}
	
	public function add($options)
	{
		
		$result = $this->client->AddContact($options+[
		'username'=> $this->username,
		'password' => $this->password
		])->AddContactResult;
		
		return $result;
		
	}
	
	public function checkMobileExist($mobileNumber)
	{
		
		$result = $this->client->CheckMobileExistInContact([
		'username'=> $this->username,
		'password' => $this->password,
		'mobileNumber'=> $mobileNumber
		])->CheckMobileExistInContactResult;
		
		return $result;
		
	}
	
	public function get($groupId,$keyword,$from,$count)
	{
		
		$result = $this->client->GetContacts([
		'username'=> $this->username,
		'password' => $this->password,
		'groupId'=> $groupId,
		'keyword'=> $keyword,
		'from'=> $from,
		'count'=> $count
		
		])->GetContactsResult;
		
		return $result;
		
	}
	
	public function getGroups()
	{
		
		$result = $this->client->GetGroups([
		'username'=> $this->username,
		'password' => $this->password
		])->GetGroupsResult;
		
		return $result;
		
	}
	
	public function change($options)
	{
		
		$result = $this->client->ChangeContact($options+[
		'username'=> $this->username,
		'password' => $this->password
		])->ChangeContactResult;
		
		return $result;
		
	}
	
	public function remove($mobilenumber)
	{
		
		$result = $this->client->RemoveContact([
		'username'=> $this->username,
		'password' => $this->password,
		'mobilenumber'=> $mobilenumber
		])->RemoveContactResult;
		
		return $result;
		
	}
	
	public function getEvents($contactId)
	{
		
		$result = $this->client->GetContactEvents([
		'username'=> $this->username,
		'password' => $this->password,
		'contactId'=> $contactId
		])->GetContactEventsResult;
		
		return $result;
		
	}
	
	
}
