<?php
/**
 *
 * @About:       Doctrine configuration
 * @File:        bootstrap.php
 * @Date:        6/26/20
 * @Version:     bittal_api 1.0
 * @Developer:   José Daniel Quijano (jose.quijano55@gmail.com)
 *
 **/
// bootstrap.php
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

require_once __DIR__ . "/vendor/autoload.php";

function getEntityManager(): EntityManager {

    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
    $dotenv->load();

	// Create a simple "default" Doctrine ORM configuration for Annotations
	$isDevMode = getenv('DEBUG');
	$proxyDir = ini_get('sys_temp_dir');
	$cache = null;
	$useSimpleAnnotationReader = false;
	$config = Setup::createAnnotationMetadataConfiguration(array($_ENV['ENTITY_DIR']), $isDevMode, $proxyDir, $cache, $useSimpleAnnotationReader);

    $config->addCustomStringFunction('DATE_FORMAT', 'Oro\ORM\Query\AST\Functions\String\DateFormat');
	$config->setAutoGenerateProxyClasses(true);
// or if you prefer yaml or XML
//$config = Setup::createXMLMetadataConfiguration(array(__DIR__."/config/xml"), $isDevMode);
//$config = Setup::createYAMLMetadataConfiguration(array(__DIR__."/config/yaml"), $isDevMode);

// database configuration parameters
	/*$conn = array(
		'driver' => 'pdo_sqlite',
		'path' => __DIR__ . '/db.sqlite',
	);*/

	$connectionParams = array(
		'dbname' => $_ENV['DATABASE_NAME'],
		'user' => $_ENV['DATABASE_USER'],
		'password' => $_ENV['DATABASE_PASSWD'],
		'host' => $_ENV['DATABASE_HOST'],
		'port' => $_ENV['DATABASE_PORT'],
		'driver' => $_ENV['DATABASE_DIVER'],
		'charset' => $_ENV['DATABASE_CHARSET']
	);
//$conn = \Doctrine\DBAL\DriverManager::getConnection($connectionParams);


// obtaining the entity manager
	return EntityManager::create($connectionParams, $config);
}

    