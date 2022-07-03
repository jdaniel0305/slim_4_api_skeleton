<?php
	/**
	 *
	 * @About:
	 * @File:        Dependencies.php
	 * @Date:        8/28/20
	 * @Version:     api 1.0
	 * @Developer:   José Daniel Quijano (jose.quijano55@gmail.com)
	 *
	 **/
	use App\Utils\DefaultErrorHandler;
	use App\Utils\LoggerFactory;
	use App\Utils\TokenAuth;
	use Psr\Container\ContainerInterface;
	use Psr\Http\Message\ResponseFactoryInterface;
	use Selective\Validation\Encoder\JsonEncoder;
	use Selective\Validation\Middleware\ValidationExceptionMiddleware;
	use Selective\Validation\Transformer\ErrorDetailsResultTransformer;
	use Slim\App;
	use Slim\Factory\AppFactory;
	use Slim\Middleware\ErrorMiddleware;

	return [
		App::class => function (ContainerInterface $container) {
			AppFactory::setContainer($container);

			return AppFactory::create();
		},

		ResponseFactoryInterface::class => function(ContainerInterface $container) {
			return $container->get(App::class)->getResponseFactory();
		},

		ValidationExceptionMiddleware::class => function (ContainerInterface $container) {
			$factory = $container->get(ResponseFactoryInterface::class);

			return new ValidationExceptionMiddleware(
				$factory,
				new ErrorDetailsResultTransformer(),
				new JsonEncoder()
			);
		},
		ErrorMiddleware::class => function (ContainerInterface $container) {
			$config = $container->get('settings')['error'];
			$app = $container->get(App::class);

			$logger = $container->get(LoggerFactory::class)
				->addFileHandler('error.log')
				->createInstance('default_error_handler');

			$errorMiddleware = new ErrorMiddleware(
				$app->getCallableResolver(),
				$app->getResponseFactory(),
				(bool)$config['display_error_details'],
				(bool)$config['log_errors'],
				(bool)$config['log_error_details'],
				$logger
			);

			$errorMiddleware->setDefaultErrorHandler($container->get(DefaultErrorHandler::class));

			return $errorMiddleware;
		},
	];
