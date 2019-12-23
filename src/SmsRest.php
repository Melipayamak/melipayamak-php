<?php

namespace Melipayamak;


class SmsRest extends BaseSms
{
	
	const PATH = "https://rest.payamak-panel.com/api/SendSMS/%s";
	
	protected $username;
	
	protected $password;
	
	public function __construct($username,$password)
	{
		
		parent::__construct($username,$password);
		
	}
	
	protected function execute($url, $data = null)
	{
		
		$fields_string = "";
		
		if (!is_null($data)) {
			
			$fields_string = http_build_query($data);
			
		}
		
		$handle = curl_init();
		
		curl_setopt($handle, CURLOPT_URL, $url);
		
		curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
		
		curl_setopt($handle, CURLOPT_SSL_VERIFYHOST, false);
		
		curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false);
		
		curl_setopt($handle, CURLOPT_POST, true);
		
		curl_setopt($handle, CURLOPT_POSTFIELDS, $fields_string);
		
		
		$response     = curl_exec($handle);
		
		$code         = curl_getinfo($handle, CURLINFO_HTTP_CODE);
		
		$curl_errno   = curl_errno($handle);
		
		$curl_error   = curl_error($handle);
		
		if ($curl_errno) {
			
			throw new \Exception($curl_error);
			
		}
		
		curl_close($handle);

		return $response;
		
		
	}
	
	public function send($to,$from,$text,$isFlash=false)
	{
		
		$url = $this->getPath(self::PATH,'SendSMS');
		
		$data = [
		'UserName' => $this->username,
		'PassWord' => $this->password,
		'To' => $to,
		'From' => $from,
		'Text' => $text,
		'IsFlash' => $isFlash
		];
		
		return $this->execute($url,$data);
		
	}
	
	public function sendByBaseNumber($text,$to,$bodyId)
	{
		
		$url = $this->getPath(self::PATH,'BaseServiceNumber');
		
		$data = [
		'UserName' => $this->username,
		'PassWord' => $this->password,
		'text' => $text,
		'to' => $to,
		'bodyId' => $bodyId
		];
		
		return $this->execute($url,$data);
		
	}
	
	public function isDelivered($id)
	{
		
		$url = $this->getPath(self::PATH,'GetDeliveries2');
		
		$data = [
		'UserName' => $this->username,
		'PassWord' => $this->password,
		'recId' => $id
		];
		
		return $this->execute($url,$data);
		
	}
	
	public function getMessages($location,$index,$count,$from='')
	{
		
		
		$url = $this->getPath(self::PATH,'GetMessages');
		
		$options = [
		'UserName'=> $this->username,
		'PassWord'=> $this->password,
		'location'=> $location,
		'index'=> $index,
		'count' => $count,
		'from' => $from
		
		];
		
		return $this->execute($url,$options);
		
		
	}
	
	public function getCredit()
	{
		
		$url = $this->getPath(self::PATH,'GetCredit');
		
		$data=[
		'UserName' => $this->username,
		'PassWord' => $this->password
		];
		
		return $this->execute($url,$data);
		
	}
	
	public function getBasePrice()
	{
		
		$url = $this->getPath(self::PATH,'GetBasePrice');
		
		$data=[
		'UserName' => $this->username,
		'PassWord' => $this->password
		];
		
		return $this->execute($url,$data);
		
	}
	
	public function getNumbers()
	{
		
		$url = $this->getPath(self::PATH,'GetUserNumbers');
		
		$data=[
		'UserName' => $this->username,
		'PassWord' => $this->password
		];
		
		return $this->execute($url,$data);
		
	}
	
}
