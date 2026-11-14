<?php

namespace Melipayamak;


class BranchAsync
{
	
	protected $username;
	
	protected $password;
	
	protected $queue;
	
	const PATH = 'http://api.payamak-panel.com/post/newbulks.asmx?wsdl';
	
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




    public function addNumberBulk($from, $title, $message, $receivers, $DateToSend)
    {
        $data = [
            'username' => $this->username,
            'password' => $this->password,
            'from' => $from,
            'title' => $title,
            'message' => $message,
            'receivers' => $receivers,
            'DateToSend' => $DateToSend
        ];

        array_push($this->queue, 'AddNumberBulk');
		array_push($this->queue, $data);
    }


    public function addNumberBulk2($from, $body, $to)
    {
        $data = [
            'username' => $this->username,
            'password' => $this->password,
            'from' => $from,
            'body' => $body,
            'to' => $to
        ];

        array_push($this->queue, 'AddNumberBulk2');
		array_push($this->queue, $data);
    }


    public function getBulkDeliveries($recIds)
    {
        $data = [
            'username' => $this->username,
            'password' => $this->password,
            'recIds' => $recIds
        ];

        array_push($this->queue, 'GetBulkDeliveries');
		array_push($this->queue, $data);
    }


    public function getBulkDeliveries2($recId)
    {
        $data = [
            'username' => $this->username,
            'password' => $this->password,
            'recId' => $recId
        ];

        array_push($this->queue, 'GetBulkDeliveries2');
		array_push($this->queue, $data);
    }


    public function getBulkDetails($bulkdId)
    {
        $data = [
            'username' => $this->username,
            'password' => $this->password,
            'bulkdId' => $bulkdId
        ];

        array_push($this->queue, 'GetBulkDetails');
		array_push($this->queue, $data);
    }

    public function sendSmsToContact($message, $title, $from, $groupId, $dateToSend)
    {
        $data = [
            'username' => $this->username,
            'password' => $this->password,
            'message' => $message,
            'title' => $title,
            'from' => $from,
            'groupId' => $groupId,
            'dateToSend' => $dateToSend
        ];

        array_push($this->queue, 'SendSmsToContact');
		array_push($this->queue, $data);
    }
}