<?php

namespace Src\Middleware;

use Src\Service\Barber\BarberTokenValidatorService;

readonly class BarberAuthMiddleware {
	private BarberTokenValidatorService $tokenValidator;
	public function __construct() {
		$this->tokenValidator = new BarberTokenValidatorService();
		$this->validate();
	}

	private function validate(): void
	{
		$token = $_SERVER["HTTP_X_API_KEY"] ?? '';
		$this->tokenValidator->validate($token);
	}
}