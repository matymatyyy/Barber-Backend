<?php 

use Src\Utils\ControllerUtils;
use Src\Middleware\AuthMiddleware;
use Src\Service\Service\ServiceCreatorService;

final readonly class ServicePostController extends AuthMiddleware {
    private ServiceCreatorService $service;

    public function __construct() {
        $this->service = new ServiceCreatorService();
    }

    public function start(): void 
    {
        $type = ControllerUtils::getPost("type");
        $price = ControllerUtils::getPost("price");

        $this->service->create($type, $price);
    }
}
