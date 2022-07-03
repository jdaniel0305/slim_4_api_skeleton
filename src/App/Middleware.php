<?php
	/**
	 *
	 * @About:
	 * @File:        Middleware.php
	 * @Date:        8/28/20
	 * @Version:     api 1.0
	 * @Developer:   José Daniel Quijano (jose.quijano55@gmail.com)
	 *
	 **/

use Psr\Http\Message\ServerRequestInterface;
use Psr\Log\LoggerInterface;
use Selective\Validation\Middleware\ValidationExceptionMiddleware;
use Slim\App;
use Slim\Middleware\ErrorMiddleware;

return static function (App $app) {
    // Parse json, form data and xml
    $app->addBodyParsingMiddleware();
    $app->add(ValidationExceptionMiddleware::class);
    $app->addRoutingMiddleware();

    // Define Custom Error Handler
    $customErrorHandler = function (
        ServerRequestInterface $request,
        Throwable $exception,
        bool $displayErrorDetails,
        bool $logErrors,
        bool $logErrorDetails,
        LoggerInterface $logger = null
    ) use ($app) {
        //$logger->error($exception->getMessage());

        $payload = ['error' => true, 'message' => $exception->getMessage().' on line '.$exception->getLine()];

        $response = $app->getResponseFactory()->createResponse();

        $response->getBody()->write(
            json_encode($payload, JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE)
        );

        return $response->withHeader('Content-Type', 'application/json')->withStatus(500, "PHP Error");
    };

    // Add Error Middleware
    $errorMiddleware = $app->addErrorMiddleware(true, true, true);
    $errorMiddleware->setDefaultErrorHandler($customErrorHandler);
};

