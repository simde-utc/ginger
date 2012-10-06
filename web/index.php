<?php
// Include the main Propel script, initialize it and add classes to inc path
require_once '../lib/propel/runtime/lib/Propel.php';
Propel::init("../build/conf/ginger-conf.php");
set_include_path("../build/classes" . PATH_SEPARATOR . get_include_path());

require_once '../lib/Slim/Slim.php';
\Slim\Slim::registerAutoloader();
$app = new \Slim\Slim();
$app->contentType('application/json; charset=utf-8');

require_once '../class/ginger.class.php';

require_once '../class/Api.class.php';
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
