<?php
require 'Slim/Slim.php';
require_once("class/DB.class.php");
require_once("class/Personne.class.php");
require_once("class/Auth.class.php");

\Slim\Slim::registerAutoloader();

$app = new \Slim\Slim();


function check_perm() {
	global $app;
	$err_code = $err_msg = NULL;
	try {
		if (empty($_GET['key'])) {
			$err_code = 1;
			throw new Exception("You need a key bastard !!");
		}
		$key = $_GET['key'];
		$auth = Auth::getInstance();
		try {
			$auth->login($key);
		}
		catch (Exception $e) {
			$err_code = 2;
			throw $e;
		}
	}
	catch (Exception $e) {
		$err_msg = $e->getMessage();
		$app->render("json.php", array("err_code"=>$err_code, "err_msg"=>$err_msg));
		return False;
	}
	
	return True;
}


$app->get('/v1/personne/details/:login', function ($login) use ($app) {
	if (check_perm()) {
		$auth = Auth::getInstance();
		try {
			$personne = new Personne($login);
			$result = "";
			if ($auth->getDroits() == "etendu") {
				$result = $personne->getDetailsEtendu();
			}
			else {
				$result = $personne->getDetailsSimple();
			}
			$app->render("json.php", array("result"=>$result));
		}
		catch (Exception $e) {
			$app->render("json.php", array("err_code"=>3,"err_msg"=>$e->getMessage()));
		}
	}
});

$app->get('/v1/personne/find/:loginpart', function ($loginpart) use ($app) {
	if (check_perm()) {
		$auth = Auth::getInstance();
		try {
			$data = Personne::find($loginpart);
			$app->render("json.php", array("result"=>$data));
		}
		catch (Exception $e) {
			$app->render("json.php", array("err_code"=>3,"err_msg"=>$e->getMessage()));
		}
	}
});



$app->run();

?>
