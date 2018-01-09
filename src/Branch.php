<?php

namespace Melipayamak;


class Branch
{
	
	protected $username;
	
	protected $password;
	
	protected $client;
	
	const PATH = 'http://api.payamak-panel.com/post/Actions.asmx?wsdl';
	
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
	
	public function get($owner)
	{
		
		$result = $this->client->GetBranchs([   
		'username' => $this->username,
		'password' => $this->password,
		'owner'=>$owner
		]
		)->GetBranchsResult;
		
		return $result;
		
	}
	
	public function remove($branchId)
	{
		
		$result = $this->client->RemoveBranch([   
		'username' => $this->username,
		'password' => $this->password,
		'branchId'=>$branchId
		]
		)->RemoveBranchResult;
		
		return $result;
		
	}
	
	public function add($branchName,$owner)
	{
		
		$data = [
		'username' => $this->username,
		'password' => $this->password,
		'branchName' => $branchName,
		'owner'=>$owner
		];
		
		$result = $this->client->AddBranch($data
		)->AddBranchResult;
		
		return $result;
		
	}
	
	public function addNumber($mobileNumbers,$branchId)
	{
		
		$data = [
		'username' => $this->username,
		'password' => $this->password,
		'branchId'=> $branchId,
		'mobileNumbers'=>$mobileNumbers
		
		];
		
		$result = $this->client->AddNumber($data
		)->AddNumberResult;
		
		return $result;
		
	}
	
	public function sendBulk($from,$title,$message,$branch,$DateToSend,$requestCount,$bulkType,$rowFrom,$rangeFrom,$rangeTo)
	{
		
		$data = [
		'username' => $this->username,
		'password' => $this->password,
		'from'=> $from,
		'title' => $title,
		'message' => $message,
		'branch'=> $branch,
		'DateToSend'=>$DateToSend,
		'requestCount'=>$requestCount,
		'bulkType'=> $bulkType,
		'rowFrom'=> $rowFrom,
		'rangeFrom'=>$rangeFrom,
		'rangeTo'=>$rangeTo,
		
		];
		
		$result = $this->client->AddBulk($data
		)->AddBulkResult;
		
		return $result;
		
	}
	
	public function sendBulk2($from,$title,$message,$branch,$DateToSend,$requestCount,$bulkType,$rowFrom,$rangeFrom,$rangeTo)
	{
		
		$data = [
		'username' => $this->username,
		'password' => $this->password,
		'from'=> $from,
		'title' => $title,
		'message' => $message,
		'branch'=> $branch,
		'DateToSend'=>$DateToSend,
		'requestCount'=>$requestCount,
		'bulkType'=> $bulkType,
		'rowFrom'=> $rowFrom,
		'rangeFrom'=>$rangeFrom,
		'rangeTo'=>$rangeTo,
		
		];
		
		$result = $this->client->AddBulk2($data
		)->AddBulk2Result;
		
		return $result;
		
	}
	
	public function getBulkCount($branch,$rangeFrom,$rangeTo)
	{
		
		$data = [
		'username' => $this->username,
		'password' => $this->password,
		'branch'=> $branch,
		'rangeFrom'=>$rangeFrom,
		'rangeTo'=>$rangeTo,
		
		];
		
		$result = $this->client->GetBulkCount($data
		)->GetBulkCountResult;
		
		return $result;
		
	}
	
	public function getBulkReceptions($bulkId,$fromRows)
	{
		
		
		$data = [
		'username' => $this->username,
		'password' => $this->password,
		'bulkId'=> $bulkId,
		'fromRows'=>$fromRows,
		
		];
		
		$result = $this->client->GetBulkReceptions($data
		)->GetBulkReceptionsResult;
		
		return $result;
		
	}
	
	public function getBulkStatus($bulkId)
	{
		
		$data = [
		'username' => $this->username,
		'password' => $this->password,
		'bulkId'=> $bulkId,
		];
		
		$result = $this->client->GetBulkStatus($data
		)->GetBulkStatusResult;
		
		return $result;
		
	}
	
	public function getTodaySent()
	{
		
		$data = [
		'username' => $this->username,
		'password' => $this->password,
		];
		
		$result = $this->client->GetTodaySent($data
		)->GetTodaySentResult;
		
		return $result;
		
	}
	
	public function getTotalSent()
	{
		
		$data = [
		'username' => $this->username,
		'password' => $this->password,
		];
		
		$result = $this->client->GetTotalSent($data
		)->GetTotalSentResult;
		
		return $result;
		
	}
	
	public function removeBulk($id)
	{
		
		$data = [
		'username' => $this->username,
		'password' => $this->password,
		'bulkId'=> $id
		];
		
		$result = $this->client->RemoveBulk($data
		)->GetTotalSentResult;
		
		return $result;
		
	}
	
	public function sendMultipleSms($to,$from,$text,$isflash,$udh)
	{
		
		$data = [
		'username' => $this->username,
		'password' => $this->password,
		'to'=> $to,
		'from'=> $from,
		'text' => $text,
		'isflash' => $isflash,
		'udh'=> $udh
		];
		
		$result;
		
		if(is_array($from)){
			
			$result = $this->client->SendMultipleSMS2($data);
			
		}
		else{
			
			$result = $this->client->SendMultipleSMS($data);
			
		}
		
		return $result;
		
	}
	
	public function updateBulkDelivery($bulkId)
	{
		
		$data=[
		'bulkId'=> $bulkId,
		'username' => $this->username,
		'password' => $this->password,
		];
		
		$result = $this->client->UpdateBulkDelivery($data)->UpdateBulkDeliveryResult;
		
		return $result;
		
	}
	
}
