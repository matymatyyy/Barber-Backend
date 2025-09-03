<?php 

use Src\Utils\ControllerUtils;
use Src\Middleware\AuthMiddleware;
use Src\Service\TurnConfig\TurnConfigCreatorService;

final readonly class TurnConfigPostController extends AuthMiddleware {
    private TurnConfigCreatorService $service;

    public function __construct() {
        $this->service = new TurnConfigCreatorService();
    }

    public function start(): void 
    {
        $barberId  = ControllerUtils::getPost("barberId ");

        $this->service->create(
        $barberId,
     );
    }
}
