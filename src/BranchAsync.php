<?php

namespace Melipayamak;


class BranchAsync
{
	
	protected $username;
	
	protected $password;
	
	protected $queue;
	
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




	
	public function get($owner)
	{
		
		$data = [   
			'username' => $this->username,
			'password' => $this->password,
			'owner'=>$owner
		];

		array_push($this->queue, 'GetBranchs');
		array_push($this->queue, $data);
		
	}
	
	public function remove($branchId)
	{
		
		$data = [   
			'username' => $this->username,
			'password' => $this->password,
			'branchId'=>$branchId
		];
		
		array_push($this->queue, 'RemoveBranch');
		array_push($this->queue, $data);
		
	}
	
	public function add($branchName,$owner)
	{
		
		$data = [
			'username' => $this->username,
			'password' => $this->password,
			'branchName' => $branchName,
			'owner'=>$owner
		];
		
		array_push($this->queue, 'AddBranch');
		array_push($this->queue, $data);
		
	}
	
	public function addNumber($mobileNumbers,$branchId)
	{
		
		$data = [
			'username' => $this->username,
			'password' => $this->password,
			'branchId'=> $branchId,
			'mobileNumbers'=>$mobileNumbers
		];

		array_push($this->queue, 'AddNumber');
		array_push($this->queue, $data);
		
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
		
		array_push($this->queue, 'AddBulk');
		array_push($this->queue, $data);
		
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
		

		array_push($this->queue, 'AddBulk2');
		array_push($this->queue, $data);
		
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
		
		array_push($this->queue, 'GetBulkCount');
		array_push($this->queue, $data);
		
	}
	
	public function getBulkReceptions($bulkId,$fromRows)
	{
		
		$data = [
			'username' => $this->username,
			'password' => $this->password,
			'bulkId'=> $bulkId,
			'fromRows'=>$fromRows,
		];
		
		array_push($this->queue, 'GetBulkReceptions');
		array_push($this->queue, $data);
		
	}
	
	public function getBulkStatus($bulkId)
	{
		
		$data = [
			'username' => $this->username,
			'password' => $this->password,
			'bulkId'=> $bulkId,
		];
		
		array_push($this->queue, 'GetBulkStatus');
		array_push($this->queue, $data);
		
	}
	
	public function getTodaySent()
	{
		
		$data = [
			'username' => $this->username,
			'password' => $this->password,
		];
		
		array_push($this->queue, 'GetTodaySent');
		array_push($this->queue, $data);
		
	}
	
	public function getTotalSent()
	{
		
		$data = [
			'username' => $this->username,
			'password' => $this->password,
		];
		
		array_push($this->queue, 'GetTotalSent');
		array_push($this->queue, $data);
		
	}
	
	public function removeBulk($id)
	{
		
		$data = [
			'username' => $this->username,
			'password' => $this->password,
			'bulkId'=> $id
		];
		
		array_push($this->queue, 'RemoveBulk');
		array_push($this->queue, $data);
		
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
		
		if(is_array($from))
			array_push($this->queue, 'SendMultipleSMS2');
		
		else array_push($this->queue, 'SendMultipleSMS');
		
		array_push($this->queue, $data);
		
	}
	
	public function updateBulkDelivery($bulkId)
	{
		
		$data=[
			'bulkId'=> $bulkId,
			'username' => $this->username,
			'password' => $this->password,
		];
		
		array_push($this->queue, 'UpdateBulkDelivery');
		array_push($this->queue, $data);
		
	}
	
}
