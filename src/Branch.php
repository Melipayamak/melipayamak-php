<?php

namespace Melipayamak;


class Branch
{

	protected $username;

	protected $password;

	protected $client;

	const PATH = 'http://api.payamak-panel.com/post/Actions.asmx?wsdl';

	public function __construct($username, $password)
	{


		if (is_null($username) || is_null($password)) {

			die('username/password is empty');

			exit;
		}

		ini_set("soap.wsdl_cache_enabled", "0");

		$this->username = $username;

		$this->password = $password;

		$this->client = new \SoapClient(self::PATH);
	}

	public function get($owner)
	{

		return $this->client->GetBranchs(
			[
				'username' => $this->username,
				'password' => $this->password,
				'owner' => $owner
			]
		)->GetBranchsResult;
	}

	public function remove($branchId)
	{

		return $this->client->RemoveBranch([
			'username' => $this->username,
			'password' => $this->password,
			'branchId' => $branchId
		])->RemoveBranchResult;
	}

	public function add($branchName, $owner)
	{
		return $this->client->AddBranch([
			'username' => $this->username,
			'password' => $this->password,
			'branchName' => $branchName,
			'owner' => $owner
		])->AddBranchResult;
	}

	public function addNumber($mobileNumbers, $branchId)
	{
		return $this->client->AddNumber([
			'username' => $this->username,
			'password' => $this->password,
			'branchId' => $branchId,
			'mobileNumbers' => $mobileNumbers
		])->AddNumberResult;
	}

	public function sendBulk($from, $title, $message, $branch, $DateToSend, $requestCount, $bulkType, $rowFrom, $rangeFrom, $rangeTo)
	{
		$data = [
			'username' => $this->username,
			'password' => $this->password,
			'from' => $from,
			'title' => $title,
			'message' => $message,
			'branch' => $branch,
			'DateToSend' => $DateToSend,
			'requestCount' => $requestCount,
			'bulkType' => $bulkType,
			'rowFrom' => $rowFrom,
			'rangeFrom' => $rangeFrom,
			'rangeTo' => $rangeTo,

		];

		return $this->client->AddBulk($data)->AddBulkResult;
	}

	public function sendBulk2($from, $title, $message, $branch, $DateToSend, $requestCount, $bulkType, $rowFrom, $rangeFrom, $rangeTo)
	{
		$data = [
			'username' => $this->username,
			'password' => $this->password,
			'from' => $from,
			'title' => $title,
			'message' => $message,
			'branch' => $branch,
			'DateToSend' => $DateToSend,
			'requestCount' => $requestCount,
			'bulkType' => $bulkType,
			'rowFrom' => $rowFrom,
			'rangeFrom' => $rangeFrom,
			'rangeTo' => $rangeTo,

		];

		return $this->client->AddBulk2($data)->AddBulk2Result;
	}

	public function getBulkCount($branch, $rangeFrom, $rangeTo)
	{
		$data = [
			'username' => $this->username,
			'password' => $this->password,
			'branch' => $branch,
			'rangeFrom' => $rangeFrom,
			'rangeTo' => $rangeTo,

		];

		return $this->client->GetBulkCount($data)->GetBulkCountResult;
	}

	public function getBulkReceptions($bulkId, $fromRows)
	{
		return $this->client->GetBulkReceptions([
			'username' => $this->username,
			'password' => $this->password,
			'bulkId' => $bulkId,
			'fromRows' => $fromRows,
		])->GetBulkReceptionsResult;
	}

	public function getBulkStatus($bulkId)
	{
		return $this->client->GetBulkStatus([
			'username' => $this->username,
			'password' => $this->password,
			'bulkId' => $bulkId,
		])->GetBulkStatusResult;
	}

	public function getTodaySent()
	{
		return $this->client->GetTodaySent([
			'username' => $this->username,
			'password' => $this->password,
		])->GetTodaySentResult;
	}

	public function getTotalSent()
	{
		return $this->client->GetTotalSent([
			'username' => $this->username,
			'password' => $this->password,
		])->GetTotalSentResult;
	}

	public function removeBulk($id)
	{
		return $this->client->RemoveBulk([
			'username' => $this->username,
			'password' => $this->password,
			'bulkId' => $id
		])->GetTotalSentResult;
	}

	public function sendMultipleSms($to, $from, $text, $isflash, $udh)
	{

		$data = [
			'username' => $this->username,
			'password' => $this->password,
			'to' => $to,
			'from' => $from,
			'text' => $text,
			'isflash' => $isflash,
			'udh' => $udh
		];

		$result;

		if (is_array($from)) {
			$result = $this->client->SendMultipleSMS2($data);
		} else {
			$result = $this->client->SendMultipleSMS($data);
		}

		return $result;
	}

	public function updateBulkDelivery($bulkId)
	{
		$data = [
			'bulkId' => $bulkId,
			'username' => $this->username,
			'password' => $this->password,
		];

		return $this->client->UpdateBulkDelivery($data)->UpdateBulkDeliveryResult;
	}


	public function getMultipleSMS3Deliveries($ids)
	{
		return $this->client->GetMultipleSMS3Deliveries([
			'username' => $this->username,
			'password' => $this->password,
			'Id' => $ids
		])->GetMultipleSMS3DeliveriesResponse;
	}


	public function getSendBulk()
	{
		return $this->client->GetSendBulk([
			'username' => $this->username,
			'password' => $this->password,
		])->GetSendBulkResponse;
	}
}
