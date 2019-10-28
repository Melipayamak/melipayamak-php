<?php

namespace Melipayamak;

class MelipayamakApi
{
	
	protected $username;
	
	protected $password;
	
	private $namespace = '\Melipayamak\\';
	
	public function __construct($username, $password)
	{
		
		
		if (is_null($username)||is_null($password)) {
			
			exit('username/password is empty');
			
		}
		
		$this->username = $username;
		
		$this->password = $password;
		
	}
	
	public function __call($name, $arguments)
	{
		
		$type = null;
		
		$class = $this->namespace . ucfirst($name);
		
		if ($name == 'sms'){
			
			$type = isset($arguments[0]) ? $arguments[0] : 'rest';
			
			$class .= ucfirst($type);
			
		}
		
		if (class_exists($class))
		{
			
			return new $class($this->username, $this->password);
			
		}
		
	}
	
}
