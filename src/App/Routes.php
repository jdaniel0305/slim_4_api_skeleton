<?php
	/**
	 *
	 * @About:
	 * @File:        Routes.php
	 * @Date:        8/28/20
	 * @Version:     api 1.0
	 * @Developer:   José Daniel Quijano (jose.quijano55@gmail.com)
	 *
	 **/

	use Slim\App;
	use Slim\Routing\RouteCollectorProxy;
	use App\Utils\TokenAuth;

	return static function (App $app) {
		$app->group('/v1', static function (RouteCollectorProxy $group) {

		})->add(TokenAuth::class);
	};

