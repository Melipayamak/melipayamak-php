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
	protected $sharedUrl;
	protected $voiceUrl;

	protected $queue;



	public function __construct($username, $password)
	{
		parent::__construct($username, $password);
		$this->queue = array();

		$this->sendUrl = $this->getPath(self::PATH, 'SendSMS');
		$this->smartUrl = $this->getPath(self::PATH, 'Smartsms');
		$this->sharedUrl = $this->getPath(self::PATH, 'ShareService');
		$this->voiceUrl = $this->getPath(self::PATH, 'Voice');
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


	public function sendOTP($to, $from, $code)
	{
		$url = $this->sendUrl . 'SendOTP';

		$data = [
			'username' => $this->username,
			'password' => $this->password,
			'to' => $to,
			'from' => $from,
			'code' => $code
		];

		array_push($this->queue, $url);
		array_push($this->queue, $data);
	}


	public function sendMultipleSMS($to, $from, $text)
	{
		$url = $this->sendUrl . 'SendMultipleSMS';

		$data = [
			'username' => $this->username,
			'password' => $this->password,
			'to' => $to,
			'from' => $from,
			'text' => $text
		];

		array_push($this->queue, $url);
		array_push($this->queue, $data);
	}


	public function sendSchedule($to, $from, $text, $scheduleDate, $period)
	{
		$url = $this->sendUrl . 'SendSchedule';

		$data = [
			'username' => $this->username,
			'password' => $this->password,
			'to' => $to,
			'from' => $from,
			'text' => $text,
			'scheduleDate' => $scheduleDate,
			'period' => $period
		];

		array_push($this->queue, $url);
		array_push($this->queue, $data);
	}


	public function getSchedule($scheduleId)
	{
		$url = $this->sendUrl . 'GetSchedule';

		$data = [
			'username' => $this->username,
			'password' => $this->password,
			'scheduleId' => $scheduleId
		];

		array_push($this->queue, $url);
		array_push($this->queue, $data);
	}


	public function getDeliveries($recID)
	{
		$url = $this->sendUrl . 'GetDeliveries';

		$data = [
			'username' => $this->username,
			'password' => $this->password,
			'recID' => $recID
		];

		array_push($this->queue, $url);
		array_push($this->queue, $data);
	}

	public function getNewDeliveries($recID)
	{
		$url = $this->sendUrl . 'GetNewDeliveries';

		$data = [
			'username' => $this->username,
			'password' => $this->password,
			'recID' => $recID
		];

		array_push($this->queue, $url);
		array_push($this->queue, $data);
	}


	public function getInboxCount($isRead)
	{
		$url = $this->sendUrl . 'GetInboxCount';

		$data = [
			'username' => $this->username,
			'password' => $this->password,
			'isRead' => $isRead
		];

		array_push($this->queue, $url);
		array_push($this->queue, $data);
	}

	public function getCredit2()
	{
		$url = $this->sendUrl . 'GetCredit2';

		$data = [
			'username' => $this->username,
			'password' => $this->password
		];

		array_push($this->queue, $url);
		array_push($this->queue, $data);
	}


	public function getSmsPrice($irancellCount, $mciCount, $from, $text)
	{
		$url = $this->sendUrl . 'GetSmsPrice';

		$data = [
			'username' => $this->username,
			'password' => $this->password,
			'irancellCount' => $irancellCount,
			'mciCount' => $mciCount,
			'from' => $from,
			'text' => $text
		];

		array_push($this->queue, $url);
		array_push($this->queue, $data);
	}


	public function baseServiceNumberSchedule($text, $to, $bodyId, $scheduleDate)
	{
		$url = $this->sendUrl . 'BaseServiceNumberSchedule';

		$data = [
			'username' => $this->username,
			'password' => $this->password,
			'text' => $text,
			'to' => $to,
			'bodyId' => $bodyId,
			'scheduleDate' => $scheduleDate
		];

		array_push($this->queue, $url);
		array_push($this->queue, $data);
	}


	public function SendSmartSms($to, $text, $from, $fromSupportOne, $fromSupportTwo)
	{
		$url = $this->smartUrl . 'Send';

		$data = [
			'username' => $this->username,
			'password' => $this->password,
			'text' => $text,
			'to' => $to,
			'from' => $from,
			'fromSupportOne' => $fromSupportOne,
			'fromSupportTwo' => $fromSupportTwo
		];

		array_push($this->queue, $url);
		array_push($this->queue, $data);
	}


	public function sendMultipleSmartSms($to, $text, $from, $fromSupportOne, $fromSupportTwo)
	{
		$url = $this->smartUrl . 'SendMultiple';

		$data = [
			'username' => $this->username,
			'password' => $this->password,
			'text' => $text,
			'to' => $to,
			'from' => $from,
			'fromSupportOne' => $fromSupportOne,
			'fromSupportTwo' => $fromSupportTwo
		];

		array_push($this->queue, $url);
		array_push($this->queue, $data);
	}


	public function getDeliveries2SmartSms($Id)
	{
		$url = $this->smartUrl . 'GetDeliveries2';

		$data = [
			'username' => $this->username,
			'password' => $this->password,
			'Id' => $Id
		];

		array_push($this->queue, $url);
		array_push($this->queue, $data);
	}


	public function getDeliveriesSmartSms($Ids)
	{
		$url = $this->smartUrl . 'GetDeliveries';

		$data = [
			'username' => $this->username,
			'password' => $this->password,
			'Ids' => $Ids
		];

		array_push($this->queue, $url);
		array_push($this->queue, $data);
	}


	public function addBody($title, $body)
	{
		$url = $this->sharedUrl . 'AddBody';

		$data = [
			'username' => $this->username,
			'password' => $this->password,
			'title' => $title,
			'body' => $body
		];

		array_push($this->queue, $url);
		array_push($this->queue, $data);
	}


	public function editBody($title, $body, $bodyId)
	{
		$url = $this->sharedUrl . 'EditBody';

		$data = [
			'username' => $this->username,
			'password' => $this->password,
			'title' => $title,
			'body' => $body,
			'bodyId' => $bodyId
		];

		array_push($this->queue, $url);
		array_push($this->queue, $data);
	}


	public function deleteBody($bodyId)
	{
		$url = $this->sharedUrl . 'DeleteBody';

		$data = [
			'username' => $this->username,
			'password' => $this->password,
			'bodyId' => $bodyId
		];

		array_push($this->queue, $url);
		array_push($this->queue, $data);
	}


	public function getBodies($keyword, $status)
	{
		$url = $this->sharedUrl . 'GetBodies';

		$data = [
			'username' => $this->username,
			'password' => $this->password,
			'keyword' => $keyword,
			'status' => $status
		];

		array_push($this->queue, $url);
		array_push($this->queue, $data);
	}


	public function sendSpeechText($text, $to)
	{
		$url = $this->voiceUrl . 'SendSpeechText';

		$data = [
			'username' => $this->username,
			'password' => $this->password,
			'text' => $text,
			'to' => $to
		];

		array_push($this->queue, $url);
		array_push($this->queue, $data);
	}


	public function sendVoiceOtp($to, $code)
	{
		$url = $this->voiceUrl . 'SendVoiceOtp';

		$data = [
			'username' => $this->username,
			'password' => $this->password,
			'code' => $code,
			'to' => $to
		];

		array_push($this->queue, $url);
		array_push($this->queue, $data);
	}


	public function sendSMSWithSpeechText($smsBody, $speechBody, $from, $to)
	{
		$url = $this->voiceUrl . 'SendSMSWithSpeechText';

		$data = [
			'username' => $this->username,
			'password' => $this->password,
			'smsBody' => $smsBody,
			'to' => $to,
			'speechBody' => $speechBody,
			'from' => $from
		];

		array_push($this->queue, $url);
		array_push($this->queue, $data);
	}

	public function sendSMSWithSpeechTextBySchduleDate($smsBody, $from, $to, $speechBody, $scheduleDate)
	{
		$url = $this->voiceUrl . 'SendSMSWithSpeechTextBySchduleDate';

		$data = [
			'username' => $this->username,
			'password' => $this->password,
			'smsBody' => $smsBody,
			'to' => $to,
			'speechBody' => $speechBody,
			'from' => $from,
			'scheduleDate' => $scheduleDate
		];

		array_push($this->queue, $url);
		array_push($this->queue, $data);
	}

	public function getSendSpeechTextStatus($recId)
	{
		$url = $this->voiceUrl . 'GetSendSpeechTextStatus';

		$data = [
			'username' => $this->username,
			'password' => $this->password,
			'recId' => $recId
		];

		array_push($this->queue, $url);
		array_push($this->queue, $data);
	}

	public function getSendSpeechTextStatuses($recIds)
	{
		$url = $this->voiceUrl . 'GetSendSpeechTextStatuses';

		$data = [
			'username' => $this->username,
			'password' => $this->password,
			'recIds' => $recIds
		];

		array_push($this->queue, $url);
		array_push($this->queue, $data);
	}

	public function getSendSMSWithSpeechTextStatus($recId)
	{
		$url = $this->voiceUrl . 'GetSendSMSWithSpeechTextStatus';

		$data = [
			'username' => $this->username,
			'password' => $this->password,
			'recId' => $recId
		];

		array_push($this->queue, $url);
		array_push($this->queue, $data);
	}

	public function sendBulkSpeechText($title, $body, $receivers, $DateToSend, $RepeatCount)
	{
		$url = $this->voiceUrl . 'SendBulkSpeechText';

		$data = [
			'username' => $this->username,
			'password' => $this->password,
			'title' => $title,
			'body' => $body,
			'receivers' => $receivers,
			'DateToSend' => $DateToSend,
			'RepeatCount' => $RepeatCount
		];

		array_push($this->queue, $url);
		array_push($this->queue, $data);
	}


	public function sendBulkVoiceSMS($title, $voiceFileId, $receivers, $DateToSend, $repeatCount)
	{
		$url = $this->voiceUrl . 'SendBulkVoiceSMS';

		$data = [
			'username' => $this->username,
			'password' => $this->password,
			'title' => $title,
			'voiceFileId' => $voiceFileId,
			'receivers' => $receivers,
			'DateToSend' => $DateToSend,
			'repeatCount' => $repeatCount
		];

		array_push($this->queue, $url);
		array_push($this->queue, $data);
	}


	public function uploadVoiceFile($title, $base64StringFile)
	{
		$url = $this->voiceUrl . 'UploadVoiceFile';

		$data = [
			'username' => $this->username,
			'password' => $this->password,
			'title' => $title,
			'base64StringFile' => $base64StringFile
		];

		array_push($this->queue, $url);
		array_push($this->queue, $data);
	}

	public function uploadVoiceFileByte($title, $file)
	{
		$url = $this->voiceUrl . 'UploadVoiceFileByte';

		$data = [
			'username' => $this->username,
			'password' => $this->password,
			'title' => $title,
			'file' => $file
		];

		array_push($this->queue, $url);
		array_push($this->queue, $data);
	}
}
