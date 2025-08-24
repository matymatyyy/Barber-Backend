<?php

namespace Src\Middleware;

use Src\Service\User\UserTokenValidatorService;

readonly class AuthMiddleware {
	private UserTokenValidatorService $tokenValidator;
	public function __construct() {
		$this->tokenValidator = new UserTokenValidatorService();
		$this->validate();
	}

	private function validate(): void
	{
		$token = $_SERVER["HTTP_X_API_KEY"] ?? '';
		$this->tokenValidator->validate($token);
	}
}