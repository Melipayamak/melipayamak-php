<?php

namespace Melipayamak;


class SmsRest extends BaseSms
{

	const PATH = "https://rest.payamak-panel.com/api/%s/";

	protected $username;
	protected $password;

	protected $sendUrl;
	protected $smartUrl;
	protected $sharedUrl;
	protected $voiceUrl;


	public function __construct($username, $password)
	{
		parent::__construct($username, $password);

		$this->sendUrl = $this->getPath(self::PATH, 'SendSMS');
		$this->smartUrl = $this->getPath(self::PATH, 'Smartsms');
		$this->sharedUrl = $this->getPath(self::PATH, 'ShareService');
		$this->voiceUrl = $this->getPath(self::PATH, 'Voice');
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

		return $this->execute($url, $data);
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

		return $this->execute($url, $data);
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

		return $this->execute($url, $data);
	}


	public function getSchedule($scheduleId)
	{
		$url = $this->sendUrl . 'GetSchedule';

		$data = [
			'username' => $this->username,
			'password' => $this->password,
			'scheduleId' => $scheduleId
		];

		return $this->execute($url, $data);
	}


	public function getDeliveries($recID)
	{
		$url = $this->sendUrl . 'GetDeliveries';

		$data = [
			'username' => $this->username,
			'password' => $this->password,
			'recID' => $recID
		];

		return $this->execute($url, $data);
	}

	public function getNewDeliveries($recID)
	{
		$url = $this->sendUrl . 'GetNewDeliveries';

		$data = [
			'username' => $this->username,
			'password' => $this->password,
			'recID' => $recID
		];

		return $this->execute($url, $data);
	}


	public function getInboxCount($isRead)
	{
		$url = $this->sendUrl . 'GetInboxCount';

		$data = [
			'username' => $this->username,
			'password' => $this->password,
			'isRead' => $isRead
		];

		return $this->execute($url, $data);
	}

	public function getCredit2()
	{
		$url = $this->sendUrl . 'GetCredit2';

		$data = [
			'username' => $this->username,
			'password' => $this->password
		];

		return $this->execute($url, $data);
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

		return $this->execute($url, $data);
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

		return $this->execute($url, $data);
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

		return $this->execute($url, $data);
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

		return $this->execute($url, $data);
	}


	public function getDeliveries2SmartSms($Id)
	{
		$url = $this->smartUrl . 'GetDeliveries2';

		$data = [
			'username' => $this->username,
			'password' => $this->password,
			'Id' => $Id
		];

		return $this->execute($url, $data);
	}


	public function getDeliveriesSmartSms($Ids)
	{
		$url = $this->smartUrl . 'GetDeliveries';

		$data = [
			'username' => $this->username,
			'password' => $this->password,
			'Ids' => $Ids
		];

		return $this->execute($url, $data);
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

		return $this->execute($url, $data);
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

		return $this->execute($url, $data);
	}


	public function deleteBody($bodyId)
	{
		$url = $this->sharedUrl . 'DeleteBody';

		$data = [
			'username' => $this->username,
			'password' => $this->password,
			'bodyId' => $bodyId
		];

		return $this->execute($url, $data);
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

		return $this->execute($url, $data);
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

		return $this->execute($url, $data);
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

		return $this->execute($url, $data);
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

		return $this->execute($url, $data);
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

		return $this->execute($url, $data);
	}

	public function getSendSpeechTextStatus($recId)
	{
		$url = $this->voiceUrl . 'GetSendSpeechTextStatus';

		$data = [
			'username' => $this->username,
			'password' => $this->password,
			'recId' => $recId
		];

		return $this->execute($url, $data);
	}

	public function getSendSpeechTextStatuses($recIds)
	{
		$url = $this->voiceUrl . 'GetSendSpeechTextStatuses';

		$data = [
			'username' => $this->username,
			'password' => $this->password,
			'recIds' => $recIds
		];

		return $this->execute($url, $data);
	}

	public function getSendSMSWithSpeechTextStatus($recId)
	{
		$url = $this->voiceUrl . 'GetSendSMSWithSpeechTextStatus';

		$data = [
			'username' => $this->username,
			'password' => $this->password,
			'recId' => $recId
		];

		return $this->execute($url, $data);
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

		return $this->execute($url, $data);
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

		return $this->execute($url, $data);
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

		return $this->execute($url, $data);
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

		return $this->execute($url, $data);
	}
}
