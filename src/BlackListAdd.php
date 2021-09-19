<?php

namespace Melipayamak;

class BlackListAdd{
	
	const PATH = 'http://api.payamak-panel.com/post/blacklist.asmx?wsdl';
	
	protected $username;
	
	protected $password;
	
	protected $client;

	
	
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
	
	public function addblacklist($title){
		$data = array(
			"username" => $this->username,
			"password" => $this->password,
			"title" => $title
		);
		$result = $this->client->BlackListAdd($data)->BlackListAddResult;
		return $result;
	}
	
}
