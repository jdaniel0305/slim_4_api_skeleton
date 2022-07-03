<?php
	/**
	 *
	 * @About:
	 * @File:        Validations.php
	 * @Date:        8/19/20
	 * @Version:     api 1.0
	 * @Developer:   José Daniel Quijano (jose.quijano55@gmail.com)
	 *
	 **/

	namespace App\Utils;
	use Auth0\SDK\Helpers\JWKFetcher;
	use Auth0\SDK\Helpers\Tokens\AsymmetricVerifier;
	use Auth0\SDK\Helpers\Tokens\IdTokenVerifier;
	use Auth0\SDK\Helpers\Tokens\SymmetricVerifier;
	use Dotenv\Dotenv;
	use Psr\Http\Message\ServerRequestInterface as Request;
	use Selective\Validation\Exception\ValidationException;
	use Selective\Validation\ValidationResult;

	class Validations
	{
		public static function tokenValidation($token)
		{
			$dotenv = Dotenv::createImmutable(__DIR__ .'/../..');
			$dotenv->load();

			$id_token  = rawurldecode($token);

			$token_issuer  = 'https://'.$_ENV['AUTH0_DOMAIN'].'/';
			$signature_verifier = null;

			if ('RS256' === $_ENV['AUTH0_TOKEN_ALG']) {
				$jwks_fetcher = new JWKFetcher();
				$jwks        = $jwks_fetcher->getKeys($token_issuer.'.well-known/jwks.json');
				$signature_verifier = new AsymmetricVerifier($jwks);
			} else if ('HS256' === $_ENV['AUTH0_TOKEN_ALG']) {
				$signature_verifier = new SymmetricVerifier($_ENV['AUTH0_CLIENT_SECRET']);
			}

			$token_verifier = new IdTokenVerifier(
				$token_issuer,
				$_ENV['AUTH0_CLIENT_ID'],
				$signature_verifier
			);

			try {
				$decoded_token = $token_verifier->verify($id_token);
				return (object) array('token_valid' => true, 'token_decode' => $decoded_token);
			} catch (\Exception $e) {
				return (object) array('token_valid' => false, 'error' => $e->getMessage());
			}
		}

		public static function validateParams($params, Request $request): void {
			$request_params = $request->getParsedBody();
			$validationResult = new ValidationResult();

			foreach ($params as $field)
			{
				if (!isset($request_params[$field]) || strlen(trim($request_params[$field])) <= 0) {
					$validationResult->addError($field, $field.' is required');
				}
			}

			if ($validationResult->fails()) {
				// Trigger the validation middleware
				throw new ValidationException('Por favor revisa los parámetros', $validationResult);
			}
		}
	}