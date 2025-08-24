<?php 

use Src\Utils\ControllerUtils;
use Src\Middleware\AuthMiddleware;
use Src\Service\Domain\DomainCreatorService;

final readonly class DomainPostController extends AuthMiddleware {
    private DomainCreatorService $service;

    public function __construct() {
        $this->service = new DomainCreatorService();
    }

    public function start(): void 
    {
        $name = ControllerUtils::getPost("name");
        $code = ControllerUtils::getPost("code");

        $this->service->create($name, $code);
    }
}
