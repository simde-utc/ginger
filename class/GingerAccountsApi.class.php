<?php

use \Httpful\Request;

require_once 'ApiInterface.class.php';


class GingerAccountsApi implements AccountsInterface {

    protected $useragent = "ginger/0.1";
    protected $url;
    protected $key;
    protected $timeout;

    public function __construct($url, $key, $timeout) {
        $this->url = $url;
        $this->key = $key;
        $this->timeout = $timeout;
    }

    public function getUserInfo($username) {
        $uri = $this->url . "$username?key=" . $this->key;
        $response = $this->callApi($uri);
        $account = $this->parseResponse($response->body);
        return $account;
    }

    public function cardLookup($uid) {
        $uri = $this->url . "badge/$uid?key=" . $this->key;
        $response = $this->callApi($uri);
        $account = $this->parseResponse($response->body);
        return $account;
    }

    protected function callApi($uri) {
        try {
            return Request::get($uri)
                ->timeout($this->timeout)
                ->expectsJson()
                ->send();
        }
        catch (Exception $ex) {
            $message = $ex->getMessage();
            if ($message === 'Unable to parse response as JSON') {
                throw new AccountsApiException($message);
            }
            else {
                throw new AccountsNetworkException($message);
            }
        }
    }

    protected function parseResponse($response) {
        $account = new Account();
        $account->username = $response->login;
        $account->firstName = $response->prenom;
        $account->lastName = $response->nom;
        $account->mail = $response->mail;
        $type = '';
        switch($response->type) {
            case 'etu':
                $type = 'ETU UTC';
                break;
            case 'escom':
                $type = 'ETU ESCOM';
                break;
            case 'pers':
                $type = 'PERSONNEL';
                break;
            case 'escompers':
                $type = 'PERSONNEL ESCOM';
                break;
        }
        $account->profile = $type;
        $account->cardSerialNumber = $response->badge_uid;
        if (!empty($response->expiration_badge)) {
            $date = DateTime::createFromFormat("Y-m-d", $response->expiration_badge);
            $account->cardEndDate = $date->getTimestamp() * 1000;
        }
        $account->legalAge = $response->is_adulte;
        return $account;
    }
}
