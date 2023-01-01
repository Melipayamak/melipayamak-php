<?php
namespace Melipayamak;

class SharedService{
	
	
	protected $username;
	
	protected $password;
	
	protected $client;
	
	const PATH = 'https://api.payamak-panel.com/post/SharedService.asmx?wsdl';
	
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
	
	
	public function getSharedServiceBody(){
		$data = array(
			"username" => $this->username,
			"password" => $this->password
		);
		
		$result=$this->client->GetSharedServiceBody($data)->GetSharedServiceBodyResult;
		return $result;
	}
	
	public function sharedServiceBodyAdd($title,$body,$blackListId){
		$data = array(
			"username" => $this->username,
			"password" => $this->password,
			"title" => $title,
			"body" => $body,
			"blackListId" => $blackListId
		);
		
		$result=$this->client->SharedServiceBodyAdd($data)->SharedServiceBodyAddResult;
		return $result;
	}
	
}
