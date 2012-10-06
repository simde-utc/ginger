<?php
require 'Slim/Slim.php';
require 'lib/api.php';
require_once 'models/Personne.class.php';
require_once 'class/Auth.class.php';
require_once 'class/ginger.class.php';

\Slim\Slim::registerAutoloader();

$app = new \Slim\Slim();
$app->contentType('application/json; charset=utf-8');
$api = new Api($app);




$app->get('/v1/:login', function ($login) use ($api) {
	$ginger = new Ginger($_GET['key']);
	$api->call_func(array($ginger, 'getPersonneDetails'), array($login));
});

$app->get('/v1/find/:loginpart', function ($loginpart) use ($api) {
	$ginger = new Ginger($_GET['key']);
	$api->call_func(array($ginger, 'findPersonne'), array($loginpart));
});


$app->run();

?>
