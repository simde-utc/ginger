<?php

class AccountsApiException extends Exception {}
class AccountsNetworkException extends Exception {}

class Account {
    public $username;
    public $firstName;
    public $lastName;
    public $mail;
    public $profile;
    public $cardSerialNumber;
    public $cardEndDate;
    public $legalAge;
}


interface AccountsInterface
{
    /**
     * @return Account
     */
    public function getUserInfo($username);

    /**
     * @return Account
     */
    public function cardLookup($uid);
}
