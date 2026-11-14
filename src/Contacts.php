<?php

namespace Melipayamak;


class Contacts
{

	protected $username;

	protected $password;

	protected $client;

	const PATH = 'http://api.payamak-panel.com/post/contacts.asmx?wsdl';

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

	public function addGroup($groupName, $Descriptions, $showToChilds)
	{
		return $this->client->AddGroup([
			'username' => $this->username,
			'password' => $this->password,
			'groupName' => $groupName,
			'Descriptions' => $Descriptions,
			'showToChilds' => $showToChilds
		])->AddGroupResult;
	}

	public function add($options)
	{
		return $this->client->AddContact($options + [
			'username' => $this->username,
			'password' => $this->password
		])->AddContactResult;
	}

	public function checkMobileExist($mobileNumber)
	{
		return $this->client->CheckMobileExistInContact([
			'username' => $this->username,
			'password' => $this->password,
			'mobileNumber' => $mobileNumber
		])->CheckMobileExistInContactResult;
	}

	public function get($groupId, $keyword, $from, $count)
	{
		return $this->client->GetContacts([
			'username' => $this->username,
			'password' => $this->password,
			'groupId' => $groupId,
			'keyword' => $keyword,
			'from' => $from,
			'count' => $count

		])->GetContactsResult;
	}

	public function getGroups()
	{
		return $this->client->GetGroups([
			'username' => $this->username,
			'password' => $this->password
		])->GetGroupsResult;
	}

	public function change($options)
	{
		return $this->client->ChangeContact($options + [
			'username' => $this->username,
			'password' => $this->password
		])->ChangeContactResult;
	}

	public function remove($mobilenumber)
	{
		return $this->client->RemoveContact([
			'username' => $this->username,
			'password' => $this->password,
			'mobilenumber' => $mobilenumber
		])->RemoveContactResult;
	}

	public function getEvents($contactId)
	{
		return $this->client->GetContactEvents([
			'username' => $this->username,
			'password' => $this->password,
			'contactId' => $contactId
		])->GetContactEventsResult;
	}


	public function addContact2($groupIds, $firstname, $lastname, $gender, $corporation, $mobilenumber)
	{
		return $this->client->AddContact2([
			'username' => $this->username,
			'password' => $this->password,
			'groupIds' => $groupIds,
			'firstname' => $firstname,
			'lastname' => $lastname,
			'gender' => $gender,
			'corporation' => $corporation,
			'mobilenumber' => $mobilenumber
		])->AddContact2Result;
	}

	public function addContactEvents($contactId, $eventName, $eventType, $eventDate)
	{
		return $this->client->AddContactEvents([
			'username' => $this->username,
			'password' => $this->password,
			'contactId' => $contactId,
			'eventName' => $eventName,
			'eventType' => $eventType,
			'eventDate' => $eventDate
		])->AddContactEventsResult;
	}

	public function changeContact2($contactId, $mobilenumber, $firstname, $lastname, $nickname, $corporation, $phone,
		$fax, $email, $gender, $province, $city, $address, $postalCode, $additionaltext, $descriptions, $contactStatus, $birthdate)
	{
		return $this->client->ChangeContact2([
			'username' => $this->username,
			'password' => $this->password,
			'contactId' => $contactId,
			'mobilenumber' => $mobilenumber,
			'firstname' => $firstname,
			'lastname' => $lastname,
			'nickname' => $nickname,
			'corporation' => $corporation,
			'phone' => $phone,
			'fax' => $fax,
			'email' => $email,
			'gender' => $gender,
			'province' => $province,
			'city' => $city,
			'address' => $address,
			'postalCode' => $postalCode,
			'additionaltext' => $additionaltext,
			'descriptions' => $descriptions,
			'contactStatus' => $contactStatus,
			'birthdate' => $birthdate

		])->ChangeContact2Result;
	}


	public function changeGroup($groupId, $groupName, $Descriptions, $showToChilds, $groupStatus)
	{
		return $this->client->ChangeGroup([
			'username' => $this->username,
			'password' => $this->password,
			'groupId' => $groupId,
			'groupName' => $groupName,
			'Descriptions' => $Descriptions,
			'showToChilds' => $showToChilds,
			'groupStatus' => $groupStatus
		])->ChangeGroupResult;
	}

	public function removeContact2($contactId, $groupId)
	{
		return $this->client->RemoveContact2([
			'username' => $this->username,
			'password' => $this->password,
			'contactId' => $contactId,
			'groupId' => $groupId
		])->RemoveContact2Result;
	}

	public function removeGroup($groupId)
	{
		return $this->client->RemoveGroup([
			'username' => $this->username,
			'password' => $this->password,
			'groupId' => $groupId
		])->RemoveGroupResult;
	}

}
