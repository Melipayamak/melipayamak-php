<?php

namespace Melipayamak;



class SmsSoap extends BaseSms
{
	
	const PATH = "http://api.payamak-panel.com/post/%s.asmx?wsdl";
	
	protected $username;
	protected $password;
	protected $sendUrl;
	protected $receiveUrl;
	protected $voiceUrl;
	protected $scheduleUrl;
	
	
	public function __construct($username,$password)
	{
		
		parent::__construct($username,$password);
		
		ini_set("soap.wsdl_cache_enabled", "0");
		
		$this->sendUrl = $this->getPath(self::PATH,'send');
		
		$this->receiveUrl = $this->getPath(self::PATH,'receive');
		
		$this->voiceUrl = $this->getPath(self::PATH,'Voice');
		
		$this->scheduleUrl = $this->getPath(self::PATH,'Schedule');
		
	}
	
	
	public function getCredit()
	{
		
		$client = new \SoapClient($this->sendUrl);
		
		
		$data = 
		[   
		'username' => $this->username,
		'password' => $this->password
		];
		
		
		$result = $client->GetCredit($data)->GetCreditResult;
		
		
		return $result;
	}
	
	public function sendByBaseNumber($text,$to,$bodyId)
    {
        
        $client = new \SoapClient($this->sendUrl);
        
        $data = 
        [   
        'username' => $this->username,
        'password' => $this->password,
        'text'=> $text,
        'to' => $to,
        'bodyId' => $bodyId
        ];
        
        
        $result;
        
        
        if(is_array($text))
            $result = $client->SendByBaseNumber($data)->SendByBaseNumberResult;
        else
            $result = $client->SendByBaseNumber2($data)->SendByBaseNumber2Result;
        
        return $result;
        
    }
	
	public function isDelivered($id)
	{
		
		
		$client = new \SoapClient($this->sendUrl);
		
		
		$data = 
		[   
		'username' => $this->username,
		'password' => $this->password,
		];
		
		
		$result;
		
		
		if(is_array($id)){
			
			
			$data['recId'] = $id;
			
			
			$result = $client->GetDeliveries3($data)->GetDeliveries3Result;
			
			
		}
		
		else{
			
			
			$data['recId'] = $id;
			
			
			$result = $client->GetDelivery2($data)->GetDelivery2Result;
			
			
		}
		
		
		
		return $result;
		
		
	}
	
	
	public function send($to,$from,$text,$isflash=false)
	{
		
		
		$client = new \SoapClient($this->sendUrl);
		
		
		$data = 
		[   
		'username' => $this->username,
		'password' => $this->password,
		'from' => $from,
		'text'=> $text,
		'isflash' => $isflash,
		'to' => $to
		];
		
		
		$result;
		
		
		if(is_array($to)){
			
			
			$result = $client->SendSimpleSMS($data)->SendSimpleSMSResult;
			
			
		}
		
		else{
			
			
			$result = $client->SendSimpleSMS2($data)->SendSimpleSMS2Result;
			
			
		}
		
		
		return $result;
		
		
		
	}
	
	
	public function send2($to,$from,$text,$isflash=false,$udh="")
	{
		
		
		$client = new \SoapClient($this->sendUrl);
		
		
		$to = is_array($to) ? $to : array($to);
		
		
		$recId = array();
		
		
		$status = 0x0;
		
		
		$result = $client->SendSms([   
		'username' => $this->username,
		'password' => $this->password,
		'from' => $from,
		'text'=> $text,
		'isflash' => $isflash,
		'to' => $to,
		'udh' =>$udh,
		'recId' => &$recId,
		'status' => &$status
		]
		);
		
		
		return $result;
		
		
	}
	
	
	public function sendWithDomain($to,$from,$text,$isflash,$domain)
	{
		
		
		//P		roblem
		$client = new \SoapClient($this->sendUrl);
		
		
		$result = $client->SendWithDomain([   
		'username' => $this->username,
		'password' => $this->password,
		'from' => $from,
		'text'=> $text,
		'isflash' => $isflash,
		'to' => $to,
		'domainName' => $domain
		]
		)->SendWithDomainResult;
		
		
		return $result;
		
		
	}
	
	
	public function getMessages($location,$index,$count,$from='')
	{
		
		
		$client = new \SoapClient($this->sendUrl);
		
		
		$result = $client->getMessages([   
		'username' => $this->username,
		'password' => $this->password,
		'location' => $location,
		'index'=> $index,
		'count' => $count,
		'from' => $from
		]
		)->getMessagesResult;
		
		
		return $result;
		
		
	}
	
	
	public function getMessagesStr($location,$index,$count,$from='')
	{
		
		
		$client = new \SoapClient($this->receiveUrl);
		
		
		$result = $client->GetMessageStr([   
		'username' => $this->username,
		'password' => $this->password,
		'location' => $location,
		'index'=> $index,
		'count' => $count,
		'from' => $from
		]
		)->GetMessageStrResult;
		
		
		return $result;
		
		
	}
	
	
	public function getMessagesByDate($location,$index,$count,$from,$dateFrom,$dateTo)
	{
		
		
		$client = new \SoapClient($this->receiveUrl);
		
		
		$result = $client->GetMessagesByDate([   
		'username' => $this->username,
		'password' => $this->password,
		'location' => $location,
		'index'=> $index,
		'count' => $count,
		'from' => $from,
		'dateTo' => $dateTo,
		'dateFrom' => $dateFrom
		]
		)->GetMessagesByDateResult;
		
		
		return $result;
		
		
	}
	
	
	public function getMessagesReceptions($msgId,$fromRows)
	{
		
		
		$client = new \SoapClient($this->receiveUrl);
		
		
		$result = $client->GetMessagesReceptions([   
		'username' => $this->username,
		'password' => $this->password,
		'msgId' => $msgId,
		'fromRows' =>$fromRows
		]
		)->GetMessagesReceptionsResult;
		
		
		return $result;
		
		
	}
	
	
	public function getUsersMessagesByDate($location,$index,$count,$from,$dateFrom,$dateTo)
	{
		
		
		$client = new \SoapClient($this->receiveUrl);
		
		
		$result = $client->GetUsersMessagesByDate([   
		'username' => $this->username,
		'password' => $this->password,
		'location' => $location,
		'index'=> $index,
		'count' => $count,
		'from' => $from,
		'dateTo' => $dateTo,
		'dateFrom' => $dateFrom
		]
		)->GetUsersMessagesByDateResult;
		
		
		return $result;
		
		
	}
	
	
	public function remove($msgIds)
	{
		
		
		$client = new \SoapClient($this->receiveUrl);
		
		
		$result = $client->RemoveMessages2([   
		'username' => $this->username,
		'password' => $this->password,
		'msgIds' => $msgIds
		]
		)->RemoveMessages2Result;
		
		
		return $result;
		
		
	}
	
	
	public function getPrice($irancell,$mtn,$from,$text)
	{
		
		
		$client = new \SoapClient($this->sendUrl);
		
		
		$result = $client->GetSmsPrice([   
		'username' => $this->username,
		'password' => $this->password,
		'irancellCount' => $irancell,
		'mtnCount'=> $mtn,
		'text' => $text,
		'from' => $from
		]
		)->GetSmsPriceResult;
		
		
		return $result;
		
		
	}
	
	
	public function getInboxCount($isRead=false)
	{
		
		
		$client = new \SoapClient($this->sendUrl);
		
		
		$result = $client->GetInboxCount([   
		'username' => $this->username,
		'password' => $this->password,
		'isRead' => $isRead,
		]
		)->GetInboxCountResult;
		
		
		return $result;
		
		
	}
	
	
	public function sendWithSpeech($to,$from,$text,$speech)
	{
		
		
		$client = new \SoapClient($this->voiceUrl);
		
		
		$result = $client->SendSMSWithSpeechText([   
		'username' => $this->username,
		'password' => $this->password,
		'from' => $from,
		'to' => $to,
		'smsBody' => $text,
		'speechBody' =>  $speech
		]
		)->SendSMSWithSpeechTextResult;
		
		
		return $result;
		
		
	}
	
	
	public function sendWithSpeechSchduleDate($to,$from,$text,$speech,$scheduleDate)
	{
		
		
		$client = new \SoapClient($this->voiceUrl);
		
		
		$result = $client->SendSMSWithSpeechTextBySchduleDate([   
		'username' => $this->username,
		'password' => $this->password,
		'from' => $from,
		'to' => $to,
		'smsBody' => $text,
		'speechBody' =>  $speech,
		'scheduleDate'=> $scheduleDate
		]
		)->SendSMSWithSpeechTextBySchduleDateResult;
		
		
		return $result;
		
		
	}
	
	
	public function getSendWithSpeech($recId)
	{
		
		
		$client = new \SoapClient($this->voiceUrl);
		
		
		$result = $client->GetSendSMSWithSpeechTextStatus([   
		'username' => $this->username,
		'password' => $this->password,
		'recId'=>$recId
		]
		);
		
		
		return $result;
		
		
	}
	
	
	public function getMultiDelivery($recId)
	{
		
		
		$client = new \SoapClient($this->sendUrl);
		
		
		$result = $client->GetMultiDelivery2([   
		'username' => $this->username,
		'password' => $this->password,
		'recId' => $recId,
		]
		)->GetMultiDelivery2Result;
		
		
		return $result;
		
		
	}
	
	
	public function sendMultipleSchedule($to,$from,$text,$isflash,$scheduleDateTime,$period)
	{
		
		
		$client = new \SoapClient($this->scheduleUrl);
		
		
		$result = $client->AddMultipleSchedule([   
		'username' => $this->username,
		'password' => $this->password,
		'to' => $to,
		'from'=>$from,
		'text'=>$text,
		'isflash'=>$isflash,
		'scheduleDateTime'=>$scheduleDateTime,
		'period' => $period
		]
		)->AddMultipleScheduleResult;
		
		
		return $result;
		
		
	}
	
	
	public function sendSchedule($to,$from,$text,$isflash,$scheduleDateTime,$period)
	{
		
		
		$client = new \SoapClient($this->scheduleUrl);
		
		
		$result = $client->AddSchedule([   
		'username' => $this->username,
		'password' => $this->password,
		'to' => $to,
		'from'=>$from,
		'text'=>$text,
		'isflash'=>$isflash,
		'scheduleDateTime'=>$scheduleDateTime,
		'period' => $period
		]
		)->AddScheduleResult;
		
		
		return $result;
		
		
	}
	
	
	public function getScheduleStatus($schId)
	{
		
		
		$client = new \SoapClient($this->scheduleUrl);
		
		
		$result = $client->GetScheduleStatus([   
		'username' => $this->username,
		'password' => $this->password,
		'scheduleId'=>$schId
		]
		)->GetScheduleStatusResult;
		
		
		return $result;
		
		
	}
	
	
	public function removeSchedule($schId)
	{
		
		
		$client = new \SoapClient($this->scheduleUrl);
		
		
		$result = $client->RemoveSchedule([   
		'username' => $this->username,
		'password' => $this->password,
		'scheduleId'=>$schId
		]
		)->RemoveScheduleResult;
		
		
		return $result;
		
		
	}
	
	
	public function addUsance($to,$from,$text,$isflash,$scheduleStartDateTime,$repeatAfterDays,$scheduleEndDateTime)
	{
		
		
		$client = new \SoapClient($this->scheduleUrl);
		
		
		$result = $client->AddUsance([   
		'username' => $this->username,
		'password' => $this->password,
		'to' => $to,
		'from'=>$from,
		'text'=>$text,
		'isflash'=>$isflash,
		'scheduleStartDateTime'=>$scheduleStartDateTime,
		'repeatAfterDays' => $repeatAfterDays,
		'scheduleEndDateTime'=>$scheduleEndDateTime
		]
		)->AddUsanceResult;
		
		
		return $result;
		
		
	}
	
	
	
}

