<?php

namespace Melipayamak;


//Async Version
class SmsRestAsync extends BaseSms
{
	
	const PATH = "https://rest.payamak-panel.com/api/SendSMS/%s";
	
	protected $username;
	
	protected $password;

	protected $queue;
	
	public function __construct($username,$password)
	{
		parent::__construct($username,$password);
		$this->queue = array();
	}
	
	public function execute()
	{

		$mh = curl_multi_init();
		$handlers = array();

		foreach ($this->queue as $key => $value) {
	        # code...
	        if(!is_array($value)){
	        	//create handler
	        	$handle = curl_init();
		
				curl_setopt($handle, CURLOPT_URL, $value);
				curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($handle, CURLOPT_SSL_VERIFYHOST, false);
				curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false);
				curl_setopt($handle, CURLOPT_POST, true);
				curl_setopt($handle, CURLOPT_POSTFIELDS, http_build_query($this->queue[$key + 1]));

				curl_multi_add_handle($mh, $handle);
				array_push($handlers, $handle);
	        }
	        
	    }



	    $responses = array();

	    do {
		    $status = curl_multi_exec($mh, $active);
		    if ($active) {
		        // Wait a short time for more activity
		        curl_multi_select($mh);
		    }
		    
		} while ($active && $status == CURLM_OK);


		//close the handles
		foreach ($handlers as $key => $value) {
			$html = curl_multi_getcontent($value); // get the content
			array_push($responses, $html);
			curl_multi_remove_handle($mh, $value);
		}
		curl_multi_close($mh);

		return $responses;
		
	}
	
	public function send($to,$from,$text,$isFlash=false)
	{
		
		$url = $this->getPath(self::PATH,'SendSMS');
		
		$data = [
		'Username' => $this->username,
		'Password' => $this->password,
		'To' => $to,
		'From' => $from,
		'Text' => $text,
		'isFlash' => $isFlash
		];
		
		array_push($this->queue, $url);
		array_push($this->queue, $data);		
	}
	
	public function isDelivered($id)
	{
		
		$url = $this->getPath(self::PATH,'GetDeliveries2');
		
		$data = [
		'UserName' => $this->username,
		'PassWord' => $this->password,
		'recId' => $id
		];
		
		array_push($this->queue, $url);
		array_push($this->queue, $data);	
		
	}
	
	public function getMessages($location,$index,$count,$from='')
	{
		
		$url = $this->getPath(self::PATH,'GetMessages');
		
		$data = [
		'UserName'=> $this->username,
		'PassWord'=> $this->password,
		'Location'=> $location,
		'Index'=> $index,
		'Count' => $count,
		'From' => $from
		
		];
		
		array_push($this->queue, $url);
		array_push($this->queue, $data);	
	}
	
	public function getCredit()
	{
		
		$url = $this->getPath(self::PATH,'GetCredit');
		
		$data = [
		'UserName' => $this->username,
		'PassWord' => $this->password
		];
		
		array_push($this->queue, $url);
		array_push($this->queue, $data);
	}
	
	public function getBasePrice()
	{
		
		$url = $this->getPath(self::PATH,'GetBasePrice');
		
		$data = [
		'UserName' => $this->username,
		'PassWord' => $this->password
		];
		
		array_push($this->queue, $url);
		array_push($this->queue, $data);		
	}
	
	public function getNumbers()
	{
		
		$url = $this->getPath(self::PATH,'GetUserNumbers');
		
		$data = [
		'UserName' => $this->username,
		'PassWord' => $this->password
		];
		
		array_push($this->queue, $url);
		array_push($this->queue, $data);			
	}
	
}
