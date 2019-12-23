<?php

namespace Melipayamak;


class ContactsAsync
{
	
	protected $username;
	
	protected $password;
	
	protected $queue;
	
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
		
		$this->queue = array();
		
	}




	public function execute(){

		$method = '';
		$requestIds = [];

		$parseResultFn = function ($method, $res) {
		    if (isset($res->{$method . 'Result'})) {
		        return $res->{$method . 'Result'};
		    }
		    return $res;
		};

		$options = [
		    'connection_timeout' => 40,
		    'trace' => true,
		    'exceptions' => true,
		    'soap_version' => SOAP_1_1,
		    'cache_wsdl' => WSDL_CACHE_BOTH,
		    'encoding' => 'UTF-8',
		    'resFn' => $parseResultFn,
		];

		$client = new \Soap\ParallelSoapClient(self::PATH, $options);

		$client->setMulti(true);
		$responses = [];

		foreach ($this->queue as $key => $value) {
			# code...
			if(!is_array($value))
				$method = $value;
			
			else $requestIds[] = $client->{$method}($value);

		}

		$responses = $client->run();
		
		foreach ($responses as $id => $response) {
    
		    if ($response instanceof SoapFault) {
		        /** handle the exception here  */
		        print 'SoapFault: ' . $response->faultcode . ' - ' . $response->getMessage() . "\n";
		    } else {
		        
		        if (!is_string($response)) {
		            $response = json_encode($response, JSON_UNESCAPED_SLASHES);
		        }
		        print 'Response is : ' . $response . "\n";
		    }
		}

		//clean queue
		$this->queue = array();
	}




	
	public function addGroup($groupName,$Descriptions,$showToChilds)
	{
		
		$data = [
			'username'=> $this->username,
			'password' => $this->password,
			'groupName'=> $groupName,
			'Descriptions'=> $Descriptions,
			'showToChilds'=> $showToChilds
		];
		
		array_push($this->queue, 'AddGroup');
		array_push($this->queue, $data);
		
	}
	
	public function add($options)
	{
		
		$data = $options + [
			'username'=> $this->username,
			'password' => $this->password
		];
		
		array_push($this->queue, 'AddContact');
		array_push($this->queue, $data);
		
	}
	
	public function checkMobileExist($mobileNumber)
	{
		
		$data = [
			'username'=> $this->username,
			'password' => $this->password,
			'mobileNumber'=> $mobileNumber
		];
		
		array_push($this->queue, 'CheckMobileExistInContact');
		array_push($this->queue, $data);
		
	}
	
	public function get($groupId,$keyword,$from,$count)
	{
		
		$data = [
			'username' => $this->username,
			'password' => $this->password,
			'groupId' => $groupId,
			'keyword' => $keyword,
			'from' => $from,
			'count' => $count
		];
		
		array_push($this->queue, 'GetContacts');
		array_push($this->queue, $data);
		
	}
	
	public function getGroups()
	{
		
		$data = [
			'username'=> $this->username,
			'password' => $this->password
		];
		
		array_push($this->queue, 'GetGroups');
		array_push($this->queue, $data);
		
	}
	
	public function change($options)
	{
		
		$data = $options + [
			'username'=> $this->username,
			'password' => $this->password
		];
		
		array_push($this->queue, 'ChangeContact');
		array_push($this->queue, $data);
		
	}
	
	public function remove($mobilenumber)
	{
		
		$data = [
			'username'=> $this->username,
			'password' => $this->password,
			'mobilenumber'=> $mobilenumber
		];
		
		array_push($this->queue, 'RemoveContact');
		array_push($this->queue, $data);
		
	}
	
	public function getEvents($contactId)
	{
		
		$data = [
			'username'=> $this->username,
			'password' => $this->password,
			'contactId'=> $contactId
		];
		
		array_push($this->queue, 'GetContactEvents');
		array_push($this->queue, $data);
		
	}
	
	
}
