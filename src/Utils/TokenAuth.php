<?php
/**
 *
 * @About:
 * @File:        TokenAuth.php
 * @Date:        8/21/20
 * @Version:     api 1.0
 * @Developer:   José Daniel Quijano (jose.quijano55@gmail.com)
 *
 **/

namespace App\Utils;

use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\StreamInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

final class TokenAuth implements MiddlewareInterface {

	/**
	 * @var ResponseFactoryInterface
	 */

	private $responseFactory;

	public function __construct(ResponseFactoryInterface $responseFactory) {
		$this->responseFactory = $responseFactory;
	}

	public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface {
		$token = $request->getHeader('Authorization')[0];



		if (!$token) {
			$response = $this->responseFactory->createResponse()
				->withHeader('Content-Type', 'application/json')
				->withStatus(401, 'Unauthorized');

			$error = (object) array('error' => true, 'message' => 'Falta token de autorización');
			$response->getBody()->write(json_encode($error));

			return  $response;
		}
		else {
			if($token != '2fdfb75ac665b5e17c1541e5850cf852')
			{
				$validate = Validations::tokenValidation($token);

				if(!$validate->token_valid)
				{
					$response = $this->responseFactory->createResponse()
						->withHeader('Content-Type', 'application/json')
						->withStatus(401, 'Unauthorized');

					$error = (object) array('error' => true, 'message' => $validate->error);
					$response->getBody()->write(json_encode($error));

					return  $response;
				}
			}
		}

		return $handler->handle($request);
	}
}