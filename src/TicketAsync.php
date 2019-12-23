<?php

namespace Melipayamak;


class TicketAsync
{
	
	protected $username;
	
	protected $password;
	
	protected $queue;
	
	const PATH = 'http://api.payamak-panel.com/post/Tickets.asmx?wsdl';
	
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




	
	public function add($title,$content,$aws=true)
	{
		
		$data = [   
			'username' => $this->username,
			'password' => $this->password,
			'title'=>$title,
			'content' =>$content,
			'alertWithSms'=> $aws
		];

		array_push($this->queue, 'AddTicket');
		array_push($this->queue, $data);
		
	}
	
	public function getReceived($ticketOwner,$ticketType,$keyword)
	{
		
		$data = [   
			'username' => $this->username,
			'password' => $this->password,
			'ticketOwner'=>$ticketOwner,
			'ticketType' =>$ticketType,
			'keyword'=> $keyword
		];

		array_push($this->queue, 'GetReceivedTickets');
		array_push($this->queue, $data);
	}
	
	public function getReceivedCount($ticketType)
	{
		
		$data = [   
			'username' => $this->username,
			'password' => $this->password,
			'ticketType' =>$ticketType,
		];

		array_push($this->queue, 'GetReceivedTicketsCount');
		array_push($this->queue, $data);
	}
	
	public function getSent($ticketOwner,$ticketType,$keyword)
	{
		
		$data = [   
			'username' => $this->username,
			'password' => $this->password,
			'ticketOwner'=>$ticketOwner,
			'ticketType' =>$ticketType,
			'keyword'=> $keyword
		];

		array_push($this->queue, 'GetSentTickets');
		array_push($this->queue, $data);
	}
	
	public function getSentCount($ticketType)
	{
		
		$data = [   
			'username' => $this->username,
			'password' => $this->password,
			'ticketType' =>$ticketType,
		];

		array_push($this->queue, 'GetSentTicketsCount');
		array_push($this->queue, $data);
		
	}
	
	public function response($ticketId,$type,$content,$alertWithSms=true)
	{
		
		$data = [   
			'username' => $this->username,
			'password' => $this->password,
			'ticketType' =>$ticketType,
			'type'=> $type,
			'content'=> $content,
			'alertWithSms'=> $alertWithSms
		];
		
		array_push($this->queue, 'ResponseTicket');
		array_push($this->queue, $data);
		
	}
	
	
}
