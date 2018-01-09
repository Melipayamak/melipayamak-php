<?php

namespace Melipayamak;


class Ticket
{
	
	protected $username;
	
	protected $password;
	
	protected $client;
	
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
		
		$this->client = new \SoapClient(self::PATH);
		
	}
	
	public function add($title,$content,$aws=true)
	{
		
		$result = $this->client->AddTicket([   
		'username' => $this->username,
		'password' => $this->password,
		'title'=>$title,
		'content' =>$content,
		'alertWithSms'=> $aws
		]
		)->AddTicketResult;
		
		return $result;
		
	}
	
	public function getReceived($ticketOwner,$ticketType,$keyword)
	{
		
		
		$result = $this->client->GetReceivedTickets([   
		'username' => $this->username,
		'password' => $this->password,
		'ticketOwner'=>$ticketOwner,
		'ticketType' =>$ticketType,
		'keyword'=> $keyword
		]
		)->GetReceivedTicketsResult;
		
		return $result;
		
	}
	
	public function getReceivedCount($ticketType)
	{
		
		$result = $this->client->GetReceivedTicketsCount([   
		'username' => $this->username,
		'password' => $this->password,
		'ticketType' =>$ticketType,
		]
		)->GetReceivedTicketsCountResult;
		
		return $result;
		
	}
	
	public function getSent($ticketOwner,$ticketType,$keyword)
	{
		
		
		$result = $this->client->GetSentTickets([   
		'username' => $this->username,
		'password' => $this->password,
		'ticketOwner'=>$ticketOwner,
		'ticketType' =>$ticketType,
		'keyword'=> $keyword
		]
		)->GetSentTicketsResult;
		
		return $result;
		
	}
	
	public function getSentCount($ticketType)
	{
		
		$result = $this->client->GetSentTicketsCount([   
		'username' => $this->username,
		'password' => $this->password,
		'ticketType' =>$ticketType,
		]
		)->GetSentTicketsCountResult;
		
		return $result;
		
	}
	
	public function response($ticketId,$type,$content,$alertWithSms=true)
	{
		
		$result = $this->client->ResponseTicket([   
		'username' => $this->username,
		'password' => $this->password,
		'ticketType' =>$ticketType,
		'type'=> $type,
		'content'=> $content,
		'alertWithSms'=> $alertWithSms
		]
		)->ResponseTicketResult;
		
		return $result;
		
	}
	
	
}
