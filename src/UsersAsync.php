<?php

namespace Melipayamak;


class UsersAsync
{
	
	protected $username;
	
	protected $password;
	
	protected $queue;
	
	const PATH = 'http://api.payamak-panel.com/post/users.asmx?wsdl';
	
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


	
	public function addPayment($options)
	{
		
		$data = $options + [
			'username' => $this->username,
			'password' => $this->password
		];
		
		array_push($this->queue, 'AddPayment');
		array_push($this->queue, $data);
		
	}
	
	public function add($options)
	{
		
		$data = $options + [
			'username'=> $this->username,
			'password' => $this->password
		];
		
		array_push($this->queue, 'AddUser');
		array_push($this->queue, $data);
		
	}
	
	public function addComplete($options)
	{
		
		$data = $options + [
			'username'=> $this->username,
			'password' => $this->password
		];
		
		array_push($this->queue, 'AddUserComplete');
		array_push($this->queue, $data);
		
	}
	
	public function addWithLocation($options)
	{
		
		$data = $options + [
			'username'=> $this->username,
			'password' => $this->password
		];
		
		array_push($this->queue, 'AddUserWithLocation');
		array_push($this->queue, $data);
		
	}
	
	public function authenticate()
	{
		
		$data = [
			'username'=> $this->username,
			'password' => $this->password
		];
		
		array_push($this->queue, 'AuthenticateUser');
		array_push($this->queue, $data);
		
	}
	
	public function changeCredit($amount,$description,$targetUsername,$GetTax)
	{
		
		$data = [
			'username'=> $this->username,
			'password' => $this->password,
			'amount'=> $amount,
			'description' => $description,
			'targetUsername' => $targetUsername,
			'GetTax' => $GetTax
		];
		
		array_push($this->queue, 'ChangeUserCredit');
		array_push($this->queue, $data);
		
	}
	
	public function forgotPassword($mobileNumber,$emailAddress,$targetUsername)
	{
		
		$data = [
			'username'=> $this->username,
			'password' => $this->password,
			'mobileNumber'=> $mobileNumber,
			'emailAddress'=> $emailAddress,
			'targetUsername'=> $targetUsername
		];
		
		array_push($this->queue, 'ForgotPassword');
		array_push($this->queue, $data);
		
	}
	
	public function getBasePrice($targetUsername)
	{
		
		$data = [
			'username'=> $this->username,
			'password' => $this->password,
			'targetUsername'=> $targetUsername
		];
		
		array_push($this->queue, 'GetUserBasePrice');
		array_push($this->queue, $data);
		
	}
	
	public function remove($targetUsername)
	{
		
		$data = [
			'username'=> $this->username,
			'password' => $this->password,
			'targetUsername'=> $targetUsername
		];
		
		array_push($this->queue, 'RemoveUser');
		array_push($this->queue, $data);
		
	}
	
	public function getCredit($targetUsername)
	{
		
		$data = [
			'username'=> $this->username,
			'password' => $this->password,
			'targetUsername'=> $targetUsername
		];
		
		array_push($this->queue, 'GetUserCredit');
		array_push($this->queue, $data);
		
	}
	
	public function getDetails($targetUsername)
	{
		
		$data = [
			'username'=> $this->username,
			'password' => $this->password,
			'targetUsername'=> $targetUsername
		];
		
		array_push($this->queue, 'GetUserDetails');
		array_push($this->queue, $data);
		
	}
	
	public function getNumbers()
	{
		
		$data = [
			'username'=> $this->username,
			'password' => $this->password
		];
		
		array_push($this->queue, 'GetUserNumbers');
		array_push($this->queue, $data);
		
	}
	
	public function getProvinces()
	{
		
		$data = [
			'username'=> $this->username,
			'password' => $this->password
		];
		
		array_push($this->queue, 'GetProvinces');
		array_push($this->queue, $data);
		
	}
	
	public function getCities($provinceId)
	{
		
		$data = [
			'username'=> $this->username,
			'password' => $this->password,
			'provinceId'=> $provinceId
		];
		
		array_push($this->queue, 'GetCities');
		array_push($this->queue, $data);
		
	}
	
	public function getExpireDate()
	{
		
		$data = [
			'username'=> $this->username,
			'password' => $this->password
		];
		
		array_push($this->queue, 'GetExpireDate');
		array_push($this->queue, $data);
	}
	
	
	public function getTransactions($targetUsername,$creditType,$dateFrom,$dateTo,$keyword)
	{
		
		$data = [
			'username'=> $this->username,
			'password' => $this->password,
			'targetUsername'=> $targetUsername,
			'keyword'=> $keyword,
			'creditType'=> $creditType,
			'dateFrom'=> $dateFrom,
			'dateTo'=> $dateTo
		];
		
		array_push($this->queue, 'GetUserTransactions');
		array_push($this->queue, $data);
		
	}
	
	public function get()
	{
		
		$data = [
			'username'=> $this->username,
			'password' => $this->password
		];
		
		array_push($this->queue, 'GetUsers');
		array_push($this->queue, $data);
		
	}
	
	public function hasFilter($text)
	{
		
		$data = [
			'username'=> $this->username,
			'password' => $this->password,
			'text'=> $text
		];
		
		array_push($this->queue, 'HasFilter');
		array_push($this->queue, $data);
		
	}
	
	
	
}
