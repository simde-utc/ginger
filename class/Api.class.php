<?php


class ApiException extends Exception {
	public function __construct($code, $msg) {
		$this->message = array("code"=>$code, "msg"=>$msg);
	}
}

class Api {
	public $app;
	
	public function __construct($app) {
		$this->app = $app;
	}
	
	public function call_func($method, $params) {
		$result = array();
		try {
			$result = call_user_func_array($method, $params);
		}
		catch (Exception $e) {
			$result['error'] = $e->getMessage();
			$this->app->response()->status(400);
		}
		$this->app->render("json.php", array("result"=>$result));
	}
}
