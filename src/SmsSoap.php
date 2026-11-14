<?php

namespace Melipayamak;



class SmsSoap extends BaseSms
{

	const PATH = "http://api.payamak-panel.com/post/%s.asmx?wsdl";

	protected $username;
	protected $password;
	protected $sendUrl;
	protected $receiveUrl;
	protected $voiceUrl;
	protected $scheduleUrl;
	protected $smartUrl;


	public function __construct($username, $password)
	{

		parent::__construct($username, $password);

		ini_set("soap.wsdl_cache_enabled", "0");

		$this->sendUrl = $this->getPath(self::PATH, 'send');

		$this->receiveUrl = $this->getPath(self::PATH, 'receive');

		$this->voiceUrl = $this->getPath(self::PATH, 'Voice');

		$this->scheduleUrl = $this->getPath(self::PATH, 'Schedule');

		$this->smartUrl = $this->getPath(self::PATH, 'Smartsms');
	}


	public function getCredit()
	{
		$client = new \SoapClient($this->sendUrl);

		$data =
			[
				'username' => $this->username,
				'password' => $this->password
			];


		$result = $client->GetCredit($data)->GetCreditResult;

		return $result;
	}

	public function sendByBaseNumber($text, $to, $bodyId)
	{
		$client = new \SoapClient($this->sendUrl);

		$data =
			[
				'username' => $this->username,
				'password' => $this->password,
				'text' => $text,
				'to' => $to,
				'bodyId' => $bodyId
			];

		$result;

		if (is_array($text))
			$result = $client->SendByBaseNumber($data)->SendByBaseNumberResult;
		else
			$result = $client->SendByBaseNumber2($data)->SendByBaseNumber2Result;

		return $result;
	}

	public function isDelivered($id)
	{
		$client = new \SoapClient($this->sendUrl);

		$data =
			[
				'username' => $this->username,
				'password' => $this->password,
				'recIds'   => $id
			];

		$result = $client->GetDeliveries($data)->GetDeliveriesResult;

		return $result;
	}


	public function send($to, $from, $text, $isflash = false)
	{
		$client = new \SoapClient($this->sendUrl);

		$data =
			[
				'username' => $this->username,
				'password' => $this->password,
				'from' => $from,
				'text' => $text,
				'isflash' => $isflash,
				'to' => $to
			];


		$result;

		if (is_array($to)) {
			$result = $client->SendSimpleSMS($data)->SendSimpleSMSResult;
		} else {
			$result = $client->SendSimpleSMS2($data)->SendSimpleSMS2Result;
		}

		return $result;
	}


	public function send2($to, $from, $text, $isflash = false, $udh = "")
	{
		$client = new \SoapClient($this->sendUrl);

		$to = is_array($to) ? $to : array($to);

		$recId = array();

		$status = 0x0;


		return $client->SendSms([
			'username' => $this->username,
			'password' => $this->password,
			'from' => $from,
			'text' => $text,
			'isflash' => $isflash,
			'to' => $to,
			'udh' => $udh,
			'recId' => &$recId,
			'status' => &$status
		]);
	}


	public function sendWithDomain($to, $from, $text, $isflash, $domain)
	{
		//P		roblem
		$client = new \SoapClient($this->sendUrl);

		return $client->SendWithDomain([
			'username' => $this->username,
			'password' => $this->password,
			'from' => $from,
			'text' => $text,
			'isflash' => $isflash,
			'to' => $to,
			'domainName' => $domain
		])->SendWithDomainResult;
	}


	public function getMessages($location, $index, $count, $from = '')
	{
		$client = new \SoapClient($this->sendUrl);

		return $client->getMessages([
			'username' => $this->username,
			'password' => $this->password,
			'location' => $location,
			'index' => $index,
			'count' => $count,
			'from' => $from
		])->getMessagesResult;
	}


	public function getMessagesStr($location, $index, $count, $from = '')
	{
		$client = new \SoapClient($this->receiveUrl);

		return $client->GetMessageStr([
			'username' => $this->username,
			'password' => $this->password,
			'location' => $location,
			'index' => $index,
			'count' => $count,
			'from' => $from
		])->GetMessageStrResult;
	}


	public function getMessagesByDate($location, $index, $count, $from, $dateFrom, $dateTo)
	{
		$client = new \SoapClient($this->receiveUrl);

		return $client->GetMessagesByDate([
			'username' => $this->username,
			'password' => $this->password,
			'location' => $location,
			'index' => $index,
			'count' => $count,
			'from' => $from,
			'dateTo' => $dateTo,
			'dateFrom' => $dateFrom
		])->GetMessagesByDateResult;
	}


	public function getMessagesReceptions($msgId, $fromRows)
	{
		$client = new \SoapClient($this->receiveUrl);

		return $client->GetMessagesReceptions([
			'username' => $this->username,
			'password' => $this->password,
			'msgId' => $msgId,
			'fromRows' => $fromRows
		])->GetMessagesReceptionsResult;
	}


	public function getUsersMessagesByDate($location, $index, $count, $from, $dateFrom, $dateTo)
	{
		$client = new \SoapClient($this->receiveUrl);

		return $client->GetUsersMessagesByDate([
			'username' => $this->username,
			'password' => $this->password,
			'location' => $location,
			'index' => $index,
			'count' => $count,
			'from' => $from,
			'dateTo' => $dateTo,
			'dateFrom' => $dateFrom
		])->GetUsersMessagesByDateResult;
	}


	public function remove($msgIds)
	{
		$client = new \SoapClient($this->receiveUrl);

		return $client->RemoveMessages2([
			'username' => $this->username,
			'password' => $this->password,
			'msgIds' => $msgIds
		])->RemoveMessages2Result;
	}


	public function getPrice($irancell, $mtn, $from, $text)
	{
		$client = new \SoapClient($this->sendUrl);

		return $client->GetSmsPrice([
			'username' => $this->username,
			'password' => $this->password,
			'irancellCount' => $irancell,
			'mtnCount' => $mtn,
			'text' => $text,
			'from' => $from
		])->GetSmsPriceResult;
	}


	public function getInboxCount($isRead = false)
	{
		$client = new \SoapClient($this->sendUrl);

		return $client->GetInboxCount([
			'username' => $this->username,
			'password' => $this->password,
			'isRead' => $isRead,
		])->GetInboxCountResult;
	}


	public function sendWithSpeech($to, $from, $text, $speech)
	{
		$client = new \SoapClient($this->voiceUrl);

		return $client->SendSMSWithSpeechText([
			'username' => $this->username,
			'password' => $this->password,
			'from' => $from,
			'to' => $to,
			'smsBody' => $text,
			'speechBody' =>  $speech
		])->SendSMSWithSpeechTextResult;
	}


	public function sendWithSpeechSchduleDate($to, $from, $text, $speech, $scheduleDate)
	{
		$client = new \SoapClient($this->voiceUrl);

		return $client->SendSMSWithSpeechTextBySchduleDate([
			'username' => $this->username,
			'password' => $this->password,
			'from' => $from,
			'to' => $to,
			'smsBody' => $text,
			'speechBody' =>  $speech,
			'scheduleDate' => $scheduleDate
		])->SendSMSWithSpeechTextBySchduleDateResult;
	}


	public function getSendWithSpeech($recId)
	{
		$client = new \SoapClient($this->voiceUrl);

		return $client->GetSendSMSWithSpeechTextStatus([
			'username' => $this->username,
			'password' => $this->password,
			'recId' => $recId
		]);
	}


	public function getMultiDelivery($recId)
	{
		$client = new \SoapClient($this->sendUrl);

		return $client->GetMultiDelivery2([
			'username' => $this->username,
			'password' => $this->password,
			'recId' => $recId,
		])->GetMultiDelivery2Result;
	}


	public function sendMultipleSchedule($to, $from, $text, $isflash, $scheduleDateTime, $period)
	{
		$client = new \SoapClient($this->scheduleUrl);

		return $client->AddMultipleSchedule([
			'username' => $this->username,
			'password' => $this->password,
			'to' => $to,
			'from' => $from,
			'text' => $text,
			'isflash' => $isflash,
			'scheduleDateTime' => $scheduleDateTime,
			'period' => $period
		])->AddMultipleScheduleResult;
	}


	public function sendSchedule($to, $from, $text, $isflash, $scheduleDateTime, $period)
	{
		$client = new \SoapClient($this->scheduleUrl);

		return $client->AddSchedule([
			'username' => $this->username,
			'password' => $this->password,
			'to' => $to,
			'from' => $from,
			'text' => $text,
			'isflash' => $isflash,
			'scheduleDateTime' => $scheduleDateTime,
			'period' => $period
		])->AddScheduleResult;
	}


	public function getScheduleStatus($schId)
	{
		$client = new \SoapClient($this->scheduleUrl);

		return $client->GetScheduleStatus([
			'username' => $this->username,
			'password' => $this->password,
			'scheduleId' => $schId
		])->GetScheduleStatusResult;
	}


	public function removeSchedule($schId)
	{
		$client = new \SoapClient($this->scheduleUrl);

		return $client->RemoveSchedule([
			'username' => $this->username,
			'password' => $this->password,
			'scheduleId' => $schId
		])->RemoveScheduleResult;
	}


	public function addUsance($to, $from, $text, $isflash, $scheduleStartDateTime, $repeatAfterDays, $scheduleEndDateTime)
	{
		$client = new \SoapClient($this->scheduleUrl);

		return $client->AddUsance([
			'username' => $this->username,
			'password' => $this->password,
			'to' => $to,
			'from' => $from,
			'text' => $text,
			'isflash' => $isflash,
			'scheduleStartDateTime' => $scheduleStartDateTime,
			'repeatAfterDays' => $repeatAfterDays,
			'scheduleEndDateTime' => $scheduleEndDateTime
		])->AddUsanceResult;
	}



	public function sendByBaseNumber3($text, $to)
	{
		$client = new \SoapClient($this->sendUrl);

		return $client->SendByBaseNumber3([
			'username' => $this->username,
			'password' => $this->password,
			'text' => $text,
			'to' => $to
		])->SendByBaseNumber3Result;
	}


	public function sendByBaseNumber4($text, $to, $bodyId, $smsPrice)
	{
		$client = new \SoapClient($this->sendUrl);

		return $client->SendByBaseNumber4([
			'username' => $this->username,
			'password' => $this->password,
			'text' => $text,
			'to' => $to,
			'bodyId' => $bodyId,
			'smsPrice' => $smsPrice
		])->SendByBaseNumber4Result;
	}


	public function sendOtp2($to, $from, $code)
	{
		$client = new \SoapClient($this->sendUrl);

		return $client->SendOtp2([
			'username' => $this->username,
			'password' => $this->password,
			'to' => $to,
			'from' => $from,
			'code' => $code
		])->SendOtp2Result;
	}

	public function sendSms2($to, $from, $text, $isflash, $udh)
	{
		$client = new \SoapClient($this->sendUrl);

		return $client->SendSms2([
			'username' => $this->username,
			'password' => $this->password,
			'to' => $to,
			'from' => $from,
			'text' => $text,
			'isflash' => $isflash,
			'udh' => $udh
		])->SendSms2Result;
	}


	public function getOutBoxCount()
	{
		$client = new \SoapClient($this->receiveUrl);

		return $client->GetOutBoxCount([
			'username' => $this->username,
			'password' => $this->password
		])->GetOutBoxCountResult;
	}


	public function addNewUsance($to, $from, $text, $isflash, $scheduleStartDateTime, $countrepeat, $scheduleEndDateTime, $periodType)
	{
		$client = new \SoapClient($this->scheduleUrl);

		return $client->AddNewUsance([
			'username' => $this->username,
			'password' => $this->password,
			'to' => $to,
			'from' => $from,
			'text' => $text,
			'isflash' => $isflash,
			'scheduleStartDateTime' => $scheduleStartDateTime,
			'countrepeat' => $countrepeat,
			'scheduleEndDateTime' => $scheduleEndDateTime,
			'periodType' => $periodType
		])->AddNewUsanceResult;
	}


	public function addScheduleSendByBaseNumber2($text, $to, $bodyId, $scheduleDate)
	{
		$client = new \SoapClient($this->scheduleUrl);

		return $client->AddScheduleSendByBaseNumber2([
			'username' => $this->username,
			'password' => $this->password,
			'to' => $to,
			'text' => $text,
			'bodyId' => $bodyId,
			'scheduleDate' => $scheduleDate
		])->AddScheduleSendByBaseNumber2Result;
	}


	public function getScheduleDetails($scheduleId)
	{
		$client = new \SoapClient($this->scheduleUrl);

		return $client->GetScheduleDetails([
			'username' => $this->username,
			'password' => $this->password,
			'scheduleId' => $scheduleId
		])->GetScheduleDetailsResult;
	}


	public function removeScheduleList($scheduleIdList)
	{
		$client = new \SoapClient($this->scheduleUrl);

		return $client->RemoveScheduleList([
			'username' => $this->username,
			'password' => $this->password,
			'scheduleIdList' => $scheduleIdList
		])->RemoveScheduleListResult;
	}


	public function getSendSpeechTextStatus($recId)
	{
		$client = new \SoapClient($this->voiceUrl);

		return $client->GetSendSpeechTextStatus([
			'username' => $this->username,
			'password' => $this->password,
			'recId' => $recId
		])->GetSendSpeechTextStatusResult;
	}

	public function getSendSpeechTextStatuses($recIds)
	{
		$client = new \SoapClient($this->voiceUrl);

		return $client->GetSendSpeechTextStatuses([
			'username' => $this->username,
			'password' => $this->password,
			'recIds' => $recIds
		])->GetSendSpeechTextStatusesResult;
	}


	public function sendBulkSpeechText($title, $body, $receivers, $DateToSend, $RepeatCount)
	{
		$client = new \SoapClient($this->voiceUrl);

		return $client->SendBulkSpeechText([
			'username' => $this->username,
			'password' => $this->password,
			'title' => $title,
			'body' => $body,
			'receivers' => $receivers,
			'DateToSend' => $DateToSend,
			'RepeatCount' => $RepeatCount
		])->SendBulkSpeechTextResult;
	}


	public function sendBulkVoiceSMS($title, $voiceFileId, $receivers, $DateToSend, $repeatCount)
	{
		$client = new \SoapClient($this->voiceUrl);

		return $client->SendBulkVoiceSMS([
			'username' => $this->username,
			'password' => $this->password,
			'title' => $title,
			'voiceFileId' => $voiceFileId,
			'receivers' => $receivers,
			'DateToSend' => $DateToSend,
			'repeatCount' => $repeatCount
		])->SendBulkVoiceSMSResult;
	}


	public function sendSpeechText($text, $to)
	{
		$client = new \SoapClient($this->voiceUrl);

		return $client->SendSpeechText([
			'username' => $this->username,
			'password' => $this->password,
			'text' => $text,
			'to' => $to
		])->SendSpeechTextResult;
	}


	public function sendVoiceOtp($to, $code)
	{
		$client = new \SoapClient($this->voiceUrl);

		return $client->SendVoiceOtp([
			'username' => $this->username,
			'password' => $this->password,
			'code' => $code,
			'to' => $to
		])->SendVoiceOtpResult;
	}


	public function getSmartSMSDeliveries($Id)
	{
		$client = new \SoapClient($this->smartUrl);

		return $client->GetSmartSMSDeliveries([
			'username' => $this->username,
			'password' => $this->password,
			'Id' => $Id
		])->GetSmartSMSDeliveriesResult;
	}

	public function getSmartSMSDetails($id)
	{
		$client = new \SoapClient($this->smartUrl);

		return $client->GetSmartSMSDetails([
			'username' => $this->username,
			'password' => $this->password,
			'Id' => $id
		])->GetSmartSMSDetailsResult;
	}

	public function sendMultipleSmartSMS($to, $text, $from, $fromSupportOne, $fromSupportTwo)
	{
		$client = new \SoapClient($this->smartUrl);

		return $client->SendMultipleSmartSMS([
			'username' => $this->username,
			'password' => $this->password,
			'to' => $to,
			'text' => $text,
			'from' => $from,
			'fromSupportOne' => $fromSupportOne,
			'fromSupportTwo' => $fromSupportTwo
		])->SendMultipleSmartSMSResult;
	}

	public function SendSmartSMS($to, $text, $from, $fromSupportOne, $fromSupportTwo)
	{
		$client = new \SoapClient($this->smartUrl);

		return $client->SendSmartSMS([
			'username' => $this->username,
			'password' => $this->password,
			'to' => $to,
			'text' => $text,
			'from' => $from,
			'fromSupportOne' => $fromSupportOne,
			'fromSupportTwo' => $fromSupportTwo
		])->SendSmartSMSResult;
	}
}
