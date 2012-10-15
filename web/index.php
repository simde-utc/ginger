<?php
// Include all dependencies
require_once '../vendor/autoload.php';

// Include model
Propel::init("../build/conf/ginger-conf.php");
set_include_path("../build/classes" . PATH_SEPARATOR . get_include_path());

// Include config
require_once '../config.php';

// Replace propel db config from config file
$propelconfig = Propel::getConfiguration(PropelConfiguration::TYPE_OBJECT);
$propelconfig->setParameter("datasources.ginger.connection.dsn", "mysql:host=".Config::$SQL_HOST.";dbname=".Config::$SQL_DB); 
$propelconfig->setParameter("datasources.ginger.connection.username", Config::$SQL_USER); 
$propelconfig->setParameter("datasources.ginger.connection.password", Config::$SQL_PASSWORD); 

// Init slim
$app = new \Slim\Slim(array(
    'debug' => false,
    'templates.path' => '../templates'
));

$app->contentType('application/json; charset=utf-8');

require_once '../class/ginger.class.php';
$Ginger = NULL;

/***********************************************************************
 *                Check la presence de l'api key
 ***********************************************************************/
$app->hook('slim.before.dispatch', function () use ($app) {
	if(empty($_GET['key']) and empty($_POST['key']))
		throw new ApiException(401);
});


/***********************************************************************
 *                        Error handler
 ***********************************************************************/
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

/***********************************************************************
 *                            404 hander
 ***********************************************************************/
$app->notFound(function () use ($app) {
	$app->render('error.json.php', array('code'=>404, 'message'=>ApiException::$http[404]), 404);
});


/***********************************************************************
 *                             Routes
 ***********************************************************************/
// récupération d'un utilisateur
$app->get('/v1/:login', function ($login) use ($app, $Ginger) {
	$ginger = new Ginger(Config::$ACCOUNTS_URL, $_GET['key']);
	$r = $ginger->getPersonneDetails($login);
	$app->render('success.json.php', array('result'=>$r));
});

// récupération des cotisations
$app->get('/v1/:login/cotisations', function ($login) use ($app, $Ginger) {
	$ginger = new Ginger(Config::$ACCOUNTS_URL, $_GET['key']);
	$r = $ginger->getPersonneCotisations($login);
	$app->render('success.json.php', array('result'=>$r));
});

// recherche d'une personne
$app->get('/v1/find/:loginpart', function ($loginpart) use ($app, $Ginger) {
	$ginger = new Ginger(Config::$ACCOUNTS_URL, $_GET['key']);
	$r = $ginger->findPersonne($loginpart);
	$app->render('success.json.php', array('result'=>$r));
});

// ajout d'une cotisation
$app->post('/v1/:login/cotisations', function ($login) use ($app, $Ginger) {
	if (empty($_POST['debut']) or empty($_POST['fin']) or empty($_POST['montant']))
		throw new ApiException(400);
	
	$ginger = new Ginger(Config::$ACCOUNTS_URL, $_POST['key']);
	$r = $ginger->addCotisation($login, strtotime($_POST['debut']), strtotime($_POST['fin']), $_POST['montant']);
	$app->render('success.json.php', array('result'=>$r));
});

/***********************************************************************
 *                             Launch
 ***********************************************************************/
$app->run();

?>
