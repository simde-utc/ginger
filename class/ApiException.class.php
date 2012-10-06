<?php

class ApiException extends Exception {
	public function __construct($code, $msg) {
		$this->message = array("code"=>$code, "msg"=>$msg);
	}
}