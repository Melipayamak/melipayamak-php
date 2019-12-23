<?php

namespace Melipayamak;



class SmsSoapAsync extends BaseSms
{
	
	const PATH = "http://api.payamak-panel.com/post/%s.asmx?wsdl";
	
	
	protected $username;
	protected $password;
	
	protected $sendUrl;
	protected $receiveUrl;
	protected $voiceUrl;
	protected $scheduleUrl;

	protected $queue;
	
	
	public function __construct($username,$password)
	{
		parent::__construct($username,$password);
		
		ini_set("soap.wsdl_cache_enabled", "0");
		
		$this->sendUrl = $this->getPath(self::PATH,'send');
		
		$this->receiveUrl = $this->getPath(self::PATH,'receive');
		
		$this->voiceUrl = $this->getPath(self::PATH,'Voice');
		
		$this->scheduleUrl = $this->getPath(self::PATH,'Schedule');


		$this->queue = array();
	}



	public function execute(){

		$endpoint = $this->queue[0];
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

		$client = new \Soap\ParallelSoapClient($endpoint, $options);

		$client->setMulti(true);
		$responses = [];

		foreach ($this->queue as $key => $value) {
			# code...
			if(!is_array($value)){
				//$value is wsdl url && differs
				if(strlen($value) > 33 && $endpoint != $value) {
					//run prior tasks if we can change endpoint
					// array_push($responses, $client->run());

					//init new client
					//unfortunately there's no way to change wsdl url during running, followings don't work!
					
					// $client = new \Soap\ParallelSoapClient($value, $options);
					// $client->__setLocation($value);
				}
				//$value is method name
				else $method = $value;
			}
			else {
				$requestIds[] = $client->{$method}($value);
			}

		}

		$responses = $client->run();
		// array_push($responses, $client->run());
		//calling multiple endpoints causes $responses to be multidimensional array
		// $results = $this->flatten($responses);

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


	function flatten(array $array) {
	    $return = array();
	    array_walk_recursive($array, function($a) use (&$return) { $return[] = $a; });
	    return $return;
	}




	
	
	public function getCredit()
	{
		
		$data = [   
			'username' => $this->username,
			'password' => $this->password
		];
		
		
		array_push($this->queue, $this->sendUrl);
		array_push($this->queue, 'getCredit');
		array_push($this->queue, $data);
		
	}
	
	
	public function isDelivered($id)
	{		
		
		$data = [   
			'username' => $this->username,
			'password' => $this->password,
			'recId' => $id
		];
		
		array_push($this->queue, $this->sendUrl);
		
		if(is_array($id))
			array_push($this->queue, 'GetDeliveries3');

		else array_push($this->queue, 'GetDelivery2');
			
		array_push($this->queue, $data);
	}
	
	
	public function send($to,$from,$text,$isflash=false)
	{
		
		$data = [   
			'username' => $this->username,
			'password' => $this->password,
			'from' => $from,
			'text'=> $text,
			'isflash' => $isflash,
			'to' => $to
		];
		
		array_push($this->queue, $this->sendUrl);

		if(is_array($to))
			array_push($this->queue, 'SendSimpleSMS');
			
		else array_push($this->queue, 'SendSimpleSMS2');
			
		
		array_push($this->queue, $data);
		
	}
	
	
	public function send2($to,$from,$text,$isflash=false,$udh="")
	{
		
		$to = is_array($to) ? $to : array($to);
		
		
		$recId = array();
		
		
		$status = 0x0;
		
		
		$data = [   
			'username' => $this->username,
			'password' => $this->password,
			'from' => $from,
			'text'=> $text,
			'isflash' => $isflash,
			'to' => $to,
			'udh' =>$udh,
			'recId' => &$recId,
			'status' => &$status
		];
		
		array_push($this->queue, $this->sendUrl);
		array_push($this->queue, 'SendSms');
		array_push($this->queue, $data);
	}
	
	
	public function sendWithDomain($to,$from,$text,$isflash,$domain)
	{
		
		$data = [   
			'username' => $this->username,
			'password' => $this->password,
			'from' => $from,
			'text'=> $text,
			'isflash' => $isflash,
			'to' => $to,
			'domainName' => $domain
		];

		array_push($this->queue, $this->sendUrl);
		array_push($this->queue, 'SendWithDomain');
		array_push($this->queue, $data);
		
	}
	
	
	public function getMessages($location,$index,$count,$from='')
	{
		
		$data = [   
			'username' => $this->username,
			'password' => $this->password,
			'location' => $location,
			'index'=> $index,
			'count' => $count,
			'from' => $from
		];

		array_push($this->queue, $this->sendUrl);
		array_push($this->queue, 'getMessages');
		array_push($this->queue, $data);
		
	}
	
	
	public function getMessagesStr($location,$index,$count,$from='')
	{
		
		
		$data = [   
			'username' => $this->username,
			'password' => $this->password,
			'location' => $location,
			'index' => $index,
			'count' => $count,
			'from' => $from
		];

		array_push($this->queue, $this->receiveUrl);
		array_push($this->queue, 'GetMessageStr');
		array_push($this->queue, $data);
		
	}
	
	
	public function getMessagesByDate($location,$index,$count,$from,$dateFrom,$dateTo)
	{
				
		$data = [   
			'username' => $this->username,
			'password' => $this->password,
			'location' => $location,
			'index'=> $index,
			'count' => $count,
			'from' => $from,
			'dateTo' => $dateTo,
			'dateFrom' => $dateFrom
		];

		array_push($this->queue, $this->receiveUrl);
		array_push($this->queue, 'GetMessagesByDate');
		array_push($this->queue, $data);		
		
	}
	
	
	public function getMessagesReceptions($msgId,$fromRows)
	{
		
		$data = [   
			'username' => $this->username,
			'password' => $this->password,
			'msgId' => $msgId,
			'fromRows' =>$fromRows
		];

		array_push($this->queue, $this->receiveUrl);
		array_push($this->queue, 'GetMessagesReceptions');
		array_push($this->queue, $data);
	}
	
	
	public function getUsersMessagesByDate($location,$index,$count,$from,$dateFrom,$dateTo)
	{
		
		$data = [   
			'username' => $this->username,
			'password' => $this->password,
			'location' => $location,
			'index'=> $index,
			'count' => $count,
			'from' => $from,
			'dateTo' => $dateTo,
			'dateFrom' => $dateFrom
		];

		array_push($this->queue, $this->receiveUrl);
		array_push($this->queue, 'GetUsersMessagesByDate');
		array_push($this->queue, $data);
	}
	
	
	public function remove($msgIds)
	{
		
		$data = [   
			'username' => $this->username,
			'password' => $this->password,
			'msgIds' => $msgIds
		];

		array_push($this->queue, $this->receiveUrl);
		array_push($this->queue, 'RemoveMessages2');
		array_push($this->queue, $data);
		
	}
	
	
	public function getPrice($irancell,$mtn,$from,$text)
	{
		$data = [   
			'username' => $this->username,
			'password' => $this->password,
			'irancellCount' => $irancell,
			'mtnCount'=> $mtn,
			'text' => $text,
			'from' => $from
		];

		array_push($this->queue, $this->sendUrl);
		array_push($this->queue, 'GetSmsPrice');
		array_push($this->queue, $data);
	}
	
	
	public function getInboxCount($isRead=false)
	{
		$data = [   
			'username' => $this->username,
			'password' => $this->password,
			'isRead' => $isRead,
		];

		array_push($this->queue, $this->sendUrl);
		array_push($this->queue, 'GetInboxCount');
		array_push($this->queue, $data);
		
	}
	
	
	public function sendWithSpeech($to,$from,$text,$speech)
	{
		
		$data = [   
			'username' => $this->username,
			'password' => $this->password,
			'from' => $from,
			'to' => $to,
			'smsBody' => $text,
			'speechBody' =>  $speech
		];

		array_push($this->queue, $this->voiceUrl);
		array_push($this->queue, 'SendSMSWithSpeechText');
		array_push($this->queue, $data);
	}
	
	
	public function sendWithSpeechSchduleDate($to,$from,$text,$speech,$scheduleDate)
	{
		
		$data = [   
			'username' => $this->username,
			'password' => $this->password,
			'from' => $from,
			'to' => $to,
			'smsBody' => $text,
			'speechBody' =>  $speech,
			'scheduleDate'=> $scheduleDate
		];

		array_push($this->queue, $this->voiceUrl);
		array_push($this->queue, 'SendSMSWithSpeechTextBySchduleDate');
		array_push($this->queue, $data);
		
	}
	
	
	public function getSendWithSpeech($recId)
	{
		
		$data = [   
			'username' => $this->username,
			'password' => $this->password,
			'recId'=>$recId
		];
		
		array_push($this->queue, $this->voiceUrl);
		array_push($this->queue, 'GetSendSMSWithSpeechTextStatus');
		array_push($this->queue, $data);
		
	}
	
	
	public function getMultiDelivery($recId)
	{
		

		$data = [   
			'username' => $this->username,
			'password' => $this->password,
			'recId' => $recId,
		];

		array_push($this->queue, $this->sendUrl);
		array_push($this->queue, 'GetMultiDelivery2');
		array_push($this->queue, $data);
	}
	
	
	public function sendMultipleSchedule($to,$from,$text,$isflash,$scheduleDateTime,$period)
	{
		
		$data = [   
			'username' => $this->username,
			'password' => $this->password,
			'to' => $to,
			'from'=>$from,
			'text'=>$text,
			'isflash'=>$isflash,
			'scheduleDateTime'=>$scheduleDateTime,
			'period' => $period
		];

		array_push($this->queue, $this->scheduleUrl);
		array_push($this->queue, 'AddMultipleSchedule');
		array_push($this->queue, $data);
	}
	
	
	public function sendSchedule($to,$from,$text,$isflash,$scheduleDateTime,$period)
	{
		$data = [   
			'username' => $this->username,
			'password' => $this->password,
			'to' => $to,
			'from' => $from,
			'text' => $text,
			'isflash' => $isflash,
			'scheduleDateTime' => $scheduleDateTime,
			'period' => $period
		];

		array_push($this->queue, $this->scheduleUrl);
		array_push($this->queue, 'AddSchedule');
		array_push($this->queue, $data);
		
	}
	
	
	public function getScheduleStatus($schId)
	{
		
		$data = [   
			'username' => $this->username,
			'password' => $this->password,
			'scheduleId'=>$schId
		];

		array_push($this->queue, $this->scheduleUrl);
		array_push($this->queue, 'GetScheduleStatus');
		array_push($this->queue, $data);
		
	}
	
	
	public function removeSchedule($schId)
	{
		$data = [   
			'username' => $this->username,
			'password' => $this->password,
			'scheduleId'=>$schId
		];

		array_push($this->queue, $this->scheduleUrl);
		array_push($this->queue, 'RemoveSchedule');
		array_push($this->queue, $data);
		
	}
	
	
	public function addUsance($to,$from,$text,$isflash,$scheduleStartDateTime,$repeatAfterDays,$scheduleEndDateTime)
	{
		
		$data = [   
			'username' => $this->username,
			'password' => $this->password,
			'to' => $to,
			'from'=>$from,
			'text'=>$text,
			'isflash'=>$isflash,
			'scheduleStartDateTime'=>$scheduleStartDateTime,
			'repeatAfterDays' => $repeatAfterDays,
			'scheduleEndDateTime'=>$scheduleEndDateTime
		];

		array_push($this->queue, $this->scheduleUrl);
		array_push($this->queue, 'AddUsance');
		array_push($this->queue, $data);
	}
	
	
	
}