<?php

namespace Melipayamak;


//Async Version
class SmsRestAsync extends BaseSms
{

	const PATH = "https://rest.payamak-panel.com/api/%s/";

	protected $username;
	protected $password;

	protected $sendUrl;
	protected $smartUrl;

	protected $queue;



	public function __construct($username, $password)
	{
		parent::__construct($username, $password);
		$this->queue = array();

		$this->sendUrl = $this->getPath(self::PATH, 'SendSMS');
		$this->smartUrl = $this->getPath(self::PATH, 'Smartsms');
	}



	public function execute()
	{
		$mh = curl_multi_init();
		$handlers = array();

		foreach ($this->queue as $key => $value) {
			# code...
			if (!is_array($value)) {
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

		array_push($this->queue, $url);
		array_push($this->queue, $data);
	}

	public function isDelivered($id)
	{
		$url = $this->sendUrl . 'GetDeliveries2';

		$data = [
			'username' => $this->username,
			'password' => $this->password,
			'recId' => $id
		];

		array_push($this->queue, $url);
		array_push($this->queue, $data);
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

		array_push($this->queue, $url);
		array_push($this->queue, $data);
	}

	public function getCredit()
	{
		$url = $this->sendUrl . 'GetCredit';

		$data = [
			'useruame' => $this->username,
			'password' => $this->password
		];

		array_push($this->queue, $url);
		array_push($this->queue, $data);
	}

	public function getBasePrice()
	{
		$url = $this->sendUrl . 'GetBasePrice';

		$data = [
			'username' => $this->username,
			'password' => $this->password
		];

		array_push($this->queue, $url);
		array_push($this->queue, $data);
	}

	public function getNumbers()
	{
		$url = $this->sendUrl . 'GetUserNumbers';

		$data = [
			'username' => $this->username,
			'password' => $this->password
		];

		array_push($this->queue, $url);
		array_push($this->queue, $data);
	}
}
