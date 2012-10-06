<?php
require '../lib/Slim/Slim.php';
require '../lib/api.php';

// Include the main Propel script, initialize it and add classes to inc path
require_once '../lib/propel/runtime/lib/Propel.php';
Propel::init("../build/conf/ginger-conf.php");
set_include_path("../build/classes" . PATH_SEPARATOR . get_include_path());

\Slim\Slim::registerAutoloader();

$app = new \Slim\Slim(array(
    'debug' => false,
    'templates.path' => '../templates'
));
$app->contentType('application/json; charset=utf-8');

require_once '../class/ginger.class.php';

$app->error(function (\Exception $e) use ($app) {
	$resul = array();
	$result['error'] = $e->getMessage();
	$code = 400;
	$app->render('error.json.php', array('code'=>$code, 'message'=>$e->getMessage()), $code);
});

$app->notFound(function () use ($app) {
    $app->render('404.json.php');
});

$app->get('/v1/:login', function ($login) use ($app) {
	$ginger = new Ginger($_GET['key']);
	$ginger->getPersonneDetails($login);
});

$app->get('/v1/find/:loginpart', function ($loginpart) use ($app) {
	$ginger = new Ginger($_GET['key']);
	$ginger->findPersonne($loginpart);
});


$app->run();

?>
