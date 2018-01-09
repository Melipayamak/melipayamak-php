<?php

namespace Melipayamak;


class Users
{
	
	protected $username;
	
	protected $password;
	
	protected $client;
	
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
		
		$this->client = new \SoapClient(self::PATH);
		
	}
	
	public function addPayment($options)
	{
		
		$result = $this->client->AddPayment($options+[
		'username'=> $this->username,
		'password' => $this->password
		])->AddPaymentResult;
		
		return $result;
		
	}
	
	public function add($options)
	{
		
		$result = $this->client->AddUser($options+[
		'username'=> $this->username,
		'password' => $this->password
		])->AddUserResult;
		
		return $result;
		
	}
	
	public function addComplete($options)
	{
		
		$result = $this->client->AddUserComplete($options+[
		'username'=> $this->username,
		'password' => $this->password
		])->AddUserCompleteResult;
		
		return $result;
		
	}
	
	public function addWithLocation($options)
	{
		
		$result = $this->client->AddUserWithLocation($options+[
		'username'=> $this->username,
		'password' => $this->password
		])->AddUserWithLocationResult;
		
		return $result;
		
	}
	
	public function authenticate()
	{
		
		$result = $this->client->AuthenticateUser([
		'username'=> $this->username,
		'password' => $this->password
		])->AuthenticateUserResult;
		
		return $result;
		
	}
	
	public function changeCredit($amount,$description,$targetUsername,$GetTax)
	{
		
		$result = $this->client->ChangeUserCredit([
		'username'=> $this->username,
		'password' => $this->password,
		'amount'=> $amount,
		'description' => $description,
		'targetUsername' => $targetUsername,
		'GetTax' => $GetTax
		])->ChangeUserCreditResult;
		
		return $result;
		
	}
	
	public function forgotPassword($mobileNumber,$emailAddress,$targetUsername)
	{
		
		$result = $this->client->ForgotPassword([
		'username'=> $this->username,
		'password' => $this->password,
		'mobileNumber'=> $mobileNumber,
		'emailAddress'=> $emailAddress,
		'targetUsername'=> $targetUsername
		])->ForgotPasswordResult;
		
		return $result;
		
	}
	
	public function getBasePrice($targetUsername)
	{
		
		$result = $this->client->GetUserBasePrice([
		'username'=> $this->username,
		'password' => $this->password,
		'targetUsername'=> $targetUsername
		])->GetUserBasePriceResult;
		
		return $result;
		
	}
	
	public function remove($targetUsername)
	{
		
		$result = $this->client->RemoveUser([
		'username'=> $this->username,
		'password' => $this->password,
		'targetUsername'=> $targetUsername
		])->RemoveUserResult;
		
		return $result;
		
	}
	
	public function getCredit($targetUsername)
	{
		
		$result = $this->client->GetUserCredit([
		'username'=> $this->username,
		'password' => $this->password,
		'targetUsername'=> $targetUsername
		])->GetUserCreditResult;
		
		return $result;
		
	}
	
	public function getDetails($targetUsername)
	{
		
		$result = $this->client->GetUserDetails([
		'username'=> $this->username,
		'password' => $this->password,
		'targetUsername'=> $targetUsername
		])->GetUserDetailsResult;
		
		return $result;
		
	}
	
	public function getNumbers()
	{
		
		$result = $this->client->GetUserNumbers([
		'username'=> $this->username,
		'password' => $this->password
		])->GetUserNumbersResult;
		
		return $result;
		
	}
	
	public function getProvinces()
	{
		
		$result = $this->client->GetProvinces([
		'username'=> $this->username,
		'password' => $this->password
		])->GetProvincesResult;
		
		return $result;
		
	}
	
	public function getCities($provinceId)
	{
		
		$result = $this->client->GetCities([
		'username'=> $this->username,
		'password' => $this->password,
		'provinceId'=> $provinceId
		])->GetCitiesResult;
		
		return $result;
		
	}
	
	public function getExpireDate()
	{
		
		$result = $this->client->GetExpireDate([
		'username'=> $this->username,
		'password' => $this->password
		])->GetExpireDateResult;
		
		return $result;
		
	}
	
	
	public function getTransactions($targetUsername,$creditType,$dateFrom,$dateTo,$keyword)
	{
		
		$result = $this->client->GetUserTransactions([
		'username'=> $this->username,
		'password' => $this->password,
		'targetUsername'=> $targetUsername,
		'keyword'=> $keyword,
		'creditType'=> $creditType,
		'dateFrom'=> $dateFrom,
		'dateTo'=> $dateTo
		])->GetUserTransactionsResult;
		
		return $result;
		
	}
	
	public function get()
	{
		
		$result = $this->client->GetUsers([
		'username'=> $this->username,
		'password' => $this->password
		])->GetUsersResult;
		
		return $result;
		
	}
	
	public function hasFilter($text)
	{
		
		$result = $this->client->HasFilter([
		'username'=> $this->username,
		'password' => $this->password,
		'text'=> $text
		])->HasFilterResult;
		
		return $result;
		
	}
	
	
	
}
