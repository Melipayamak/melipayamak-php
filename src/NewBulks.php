<?php

namespace Melipayamak;


class NewBulks
{


    protected $username;

    protected $password;

    protected $client;

    const PATH = 'http://api.payamak-panel.com/post/newbulks.asmx?wsdl';

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



    public function addNumberBulk($from, $title, $message, $receivers, $DateToSend)
    {
        return $this->client->AddNumberBulk([
            'username' => $this->username,
            'password' => $this->password,
            'from' => $from,
            'title' => $title,
            'message' => $message,
            'receivers' => $receivers,
            'DateToSend' => $DateToSend
        ])->AddNumberBulkResult;
    }


    public function addNumberBulk2($from, $body, $to)
    {
        return $this->client->AddNumberBulk2([
            'username' => $this->username,
            'password' => $this->password,
            'from' => $from,
            'body' => $body,
            'to' => $to
        ])->AddNumberBulk2Result;
    }


    public function getBulkDeliveries($recIds)
    {
        return $this->client->GetBulkDeliveries([
            'username' => $this->username,
            'password' => $this->password,
            'recIds' => $recIds
        ])->GetBulkDeliveriesResult;
    }


    public function getBulkDeliveries2($recId)
    {
        return $this->client->GetBulkDeliveries2([
            'username' => $this->username,
            'password' => $this->password,
            'recId' => $recId
        ])->GetBulkDeliveries2Result;
    }


    public function getBulkDetails($bulkdId)
    {
        return $this->client->GetBulkDetails([
            'username' => $this->username,
            'password' => $this->password,
            'bulkdId' => $bulkdId
        ])->GetBulkDetailsResult;
    }

    public function sendSmsToContact($message, $title, $from, $groupId, $dateToSend)
    {
        return $this->client->SendSmsToContact([
            'username' => $this->username,
            'password' => $this->password,
            'message' => $message,
            'title' => $title,
            'from' => $from,
            'groupId' => $groupId,
            'dateToSend' => $dateToSend
        ])->SendSmsToContactResult;
    }

}
