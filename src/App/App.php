<?php
	/**
	 *
	 * @About:
	 * @File:        App.php
	 * @Date:        8/28/20
	 * @Version:     api 1.0
	 * @Developer:   José Daniel Quijano (jose.quijano55@gmail.com)
	 *
	 **/

    namespace App;

    use DI\ContainerBuilder;
    use Slim\App;

    require __DIR__ . '/../../vendor/autoload.php';

    require __DIR__ . '/../../bootstrap.php';

    $containerBuilder = new ContainerBuilder();

    $containerBuilder->addDefinitions(__DIR__. '/Dependencies.php');

    $container = $containerBuilder->build();

    $app = $container->get(App::class);

    (require __DIR__ . '/Routes.php')($app);

    (require __DIR__ . '/Middleware.php')($app);

    return $app;
