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
	if(empty($_GET['key']) and empty($_POST['key']))
		throw new ApiException(401);
});


/**
 * Error handler
 */
$app->error(function (\Exception $e) use ($app) {
	if (!($e instanceof ApiException)) {
		$code = 500;
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
	$app->render('error.json.php', array('code'=>404, 'message'=>ApiException::$http[404]), 404);
});


$app->get('/v1/:login', function ($login) use ($app) {
	$ginger = new Ginger($_GET['key']);
	$r = $ginger->getPersonneDetails($login);
	$app->render('success.json.php', array('result'=>$r));
});

$app->get('/v1/:login/cotisations', function ($login) use ($app) {
	$ginger = new Ginger($_GET['key']);
	$r = $ginger->getPersonneCotisations($login);
	$app->render('success.json.php', array('result'=>$r));
});

$app->get('/v1/find/:loginpart', function ($loginpart) use ($app) {
	$ginger = new Ginger($_GET['key']);
	$r = $ginger->findPersonne($loginpart);
	$app->render('success.json.php', array('result'=>$r));
});

$app->post('/v1/:login/cotisations', function ($login) use ($app) {
	$ginger = new Ginger($_POST['key']);
	if (empty($_POST['debut']) or empty($_POST['fin']))
		throw new ApiException(400);
	$r = $ginger->addCotisation($login, strtotime($_POST['debut']), strtotime($_POST['fin']));
	$app->render('success.json.php', array('result'=>$r));
});


$app->run();

?>
