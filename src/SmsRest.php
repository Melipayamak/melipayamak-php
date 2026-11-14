<?php

namespace Melipayamak;


class SmsRest extends BaseSms
{

	const PATH = "https://rest.payamak-panel.com/api/%s/";

	protected $username;
	protected $password;

	protected $sendUrl;
	protected $smartUrl;

	
	public function __construct($username, $password)
	{
		parent::__construct($username, $password);

		$this->sendUrl = $this->getPath(self::PATH, 'SendSMS');
		$this->smartUrl = $this->getPath(self::PATH, 'Smartsms');
	}


	protected function execute($url, $data = null)
	{

		$fields_string = "";

		if (!is_null($data)) {

			$fields_string = http_build_query($data);
		}

		$handle = curl_init();

		curl_setopt($handle, CURLOPT_URL, $url);

		curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);

		curl_setopt($handle, CURLOPT_SSL_VERIFYHOST, false);

		curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false);

		curl_setopt($handle, CURLOPT_POST, true);

		curl_setopt($handle, CURLOPT_POSTFIELDS, $fields_string);


		$response     = curl_exec($handle);

		$code         = curl_getinfo($handle, CURLINFO_HTTP_CODE);

		$curl_errno   = curl_errno($handle);

		$curl_error   = curl_error($handle);

		if ($curl_errno) {

			throw new \Exception($curl_error);
		}

		curl_close($handle);

		return $response;
	}

	public function send($to, $from, $text, $isFlash = false)
	{
		$url = $this->sendUrl . 'SendSMS';

		$data = [
			'username' => $this->username,
			'password' => $this->password,
			'to' => $to,
			'from' => $from,
			'text' => $text,
			'isflash' => $isFlash
		];

		return $this->execute($url, $data);
	}

	public function sendByBaseNumber($text, $to, $bodyId)
	{
		$url = $this->sendUrl . 'BaseServiceNumber';

		$data = [
			'username' => $this->username,
			'password' => $this->password,
			'text' => $text,
			'to' => $to,
			'bodyId' => $bodyId
		];

		return $this->execute($url, $data);
	}

	public function isDelivered($id)
	{
		$url = $this->sendUrl . 'GetDeliveries2';

		$data = [
			'username' => $this->username,
			'password' => $this->password,
			'recId' => $id
		];

		return $this->execute($url, $data);
	}

	public function getMessages($location, $index, $count, $from = '')
	{
		$url = $this->sendUrl . 'GetMessages';

		$data = [
			'username' => $this->username,
			'password' => $this->password,
			'location' => $location,
			'index' => $index,
			'count' => $count,
			'from' => $from

		];

		return $this->execute($url, $data);
	}

	public function getCredit()
	{
		$url = $this->sendUrl . 'GetCredit';

		$data = [
			'username' => $this->username,
			'password' => $this->password
		];

		return $this->execute($url, $data);
	}

	public function getBasePrice()
	{
		$url = $this->sendUrl . 'GetBasePrice';

		$data = [
			'username' => $this->username,
			'password' => $this->password
		];

		return $this->execute($url, $data);
	}

	public function getNumbers()
	{
		$url = $this->sendUrl . 'GetUserNumbers';

		$data = [
			'username' => $this->username,
			'password' => $this->password
		];

		return $this->execute($url, $data);
	}
}
