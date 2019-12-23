<?php

namespace Melipayamak;


abstract class BaseSms
{
	
	const PATH = '';
	
	protected $username;
	
	protected $password;


	public function __construct($username,$password)
	{
		$this->username = $username;
		$this->password = $password;
	}
	
	protected function getPath($path,$method)
	{
		return sprintf($path, $method);
	}
	
}
