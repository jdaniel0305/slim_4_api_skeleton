<?php
/**
 *
 * @About:       Cli config for Doctrine ORM
 * @File:        cli-config.php
 * @Date:        6/26/20
 * @Version:     bittal_api 1.0
 * @Developer:   José Daniel Quijano (jose.quijano55@gmail.com)
 *
 **/
	use Doctrine\ORM\Tools\Console\ConsoleRunner;
	//Charge enviroment variables


	/*$dotenv->required([
		'DATABASE_HOST',
		'DATABASE_NAME',
		'DATABASE_PORT',
		'DATABASE_USER',
		'DATABASE_PASSWD',
		'DATABASE_DIVER',
		'DATABASE_CHARSET',
        'DEBUG'
	]);*/

	// cli-config.php
	require_once __DIR__ . "/bootstrap.php";

	$entityManager = getEntityManager();
	$con = $entityManager->getConnection();
try {
    $con->getDatabasePlatform()->registerDoctrineTypeMapping('enum', 'string');
} catch (\Doctrine\DBAL\Exception $e) {
}

return ConsoleRunner::createHelperSet($entityManager);

    