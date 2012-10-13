<?php
require_once 'vendor/autoload.php';
require_once 'config.php';

use Doctrine\Common\ClassLoader,
    Doctrine\ORM\Configuration,
    Doctrine\ORM\EntityManager,
		Doctrine\ORM\Tools\Setup;

// Changes generated config
$isDevMode = false;

// Set up class loading. You could use different autoloaders, provided by your favorite framework,
// if you want to.
$classLoader = new ClassLoader('Entities', __DIR__."/lib");
$classLoader->register();
$classLoader = new ClassLoader('Proxies', __DIR__."/lib");
$classLoader->register();

// Set up metatdata
$config = Setup::createYAMLMetadataConfiguration(array(__DIR__."/lib/Entities/Mappings"), $isDevMode);

// Proxy configuration
$config->setProxyDir(__DIR__ . '/lib/Proxies');
$config->setProxyNamespace('Proxies');

// Database connection information
$connectionOptions = array(
    'driver'   => 'pdo_mysql',
    'user'     => Config::$SQL_USER,
    'password' => Config::$SQL_PASSWORD,
    'dbname'   => Config::$SQL_DB,
		'host'		 => Config::$SQL_HOST,
);


// Create EntityManager
$em = EntityManager::create($connectionOptions, $config);
