<?php
// Include the main Propel script, initialize it and add classes to inc path
require_once '../lib/propel/runtime/lib/Propel.php';
Propel::init("../build/conf/ginger-conf.php");
set_include_path("../build/classes" . PATH_SEPARATOR . get_include_path());

require_once '../lib/Slim/Slim.php';
\Slim\Slim::registerAutoloader();

$app = new \Slim\Slim(array(
    'debug' => false,
    'templates.path' => '../templates'
));
$app->contentType('application/json; charset=utf-8');

require_once '../class/ginger.class.php';

/**
 * Check la presence de l'api key
 */
$app->hook('slim.before.dispatch', function () {
	if(empty($_GET['key']))
		throw new ApiException(401);
});


/**
 * Error handler
 */
$app->error(function (\Exception $e) use ($app) {
	if (!($e instanceof ApiException)) {
		$code = 400;
	}
	else {
		$code = $e->getCode();
	}
	$message = $e->getMessage();
	$app->render('error.json.php', array('code'=>$code, 'message'=>$message), $code);
});

/**
 * 404 hander
 */
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
