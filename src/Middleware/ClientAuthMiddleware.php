<?php

namespace Src\Middleware;

use Src\Service\Client\ClientTokenValidatorService;

readonly class ClientAuthMiddleware {
	private ClientTokenValidatorService $tokenValidator;
	public function __construct() {
		$this->tokenValidator = new ClientTokenValidatorService();
		$this->validate();
	}

	private function validate(): void
	{
		$token = $_SERVER["HTTP_X_API_KEY"] ?? '';
		$this->tokenValidator->validate($token);
	}
}