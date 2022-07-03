<?php
	/**
 *
 * @About:
 * @File:        Responder.php
 * @Date:        8/21/20
 * @Version:     api 1.0
 * @Developer:   José Daniel Quijano (jose.quijano55@gmail.com)
 *
 **/

	namespace App\Utils;

	use JsonException;
	use Psr\Http\Message\ResponseFactoryInterface;
	use Psr\Http\Message\ResponseInterface;

	/**
	 * A generic responder.
	 */
	final class Responder
	{
		private $twig;

		private $urlGenerator;

		/**
		 * @var ResponseFactoryInterface
		 */
		private $responseFactory;

		/**
		 * The constructor
		 * @param ResponseFactoryInterface $responseFactory The response factory
		 */
		public function __construct(
			ResponseFactoryInterface $responseFactory
		) {
			$this->responseFactory = $responseFactory;
		}

		/**
		 * Create a new response.
		 *
		 * @return ResponseInterface The response
		 */
		public function createResponse(): ResponseInterface
		{
			return $this->responseFactory->createResponse()->withHeader('Content-Type', 'text/html; charset=utf-8');
		}

		/**
		 * Output rendered template.
		 *
		 * @param ResponseInterface $response The response
		 * @param string $template Template pathname relative to templates directory
		 * @param array $data Associative array of template variables
		 *
		 * @return ResponseInterface The response
		 */

		/**
		 * Creates a redirect for the given url / route name.
		 *
		 * This method prepares the response object to return an HTTP Redirect
		 * response to the client.
		 *
		 * @param ResponseInterface $response The response
		 * @param string $destination The redirect destination (url or route name)
		 * @param array<mixed> $data Named argument replacement data
		 * @param array<mixed> $queryParams Optional query string parameters
		 *
		 * @return ResponseInterface The response
		 */

		/**
		 * Write JSON to the response body.
		 *
		 * This method prepares the response object to return an HTTP JSON
		 * response to the client.
		 *
		 * @param ResponseInterface $response The response
		 * @param mixed $data The data
		 * @param int $options Json encoding options
		 *
		 * @throws JsonException
		 *
		 * @return ResponseInterface The response
		 */
		public function json(
			ResponseInterface $response,
			$data = null,
			int $options = 0
		): ResponseInterface {
			$response = $response->withHeader('Content-Type', 'application/json');
			$response->getBody()->write((string)json_encode($data, 0));

			return $response;
		}
	}