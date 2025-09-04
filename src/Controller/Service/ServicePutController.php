<?php 

use Src\Utils\ControllerUtils;
use Src\Service\Service\ServiceUpdateService;

final readonly class ServicePutController {
    private ServiceUpdateService $service;

    public function __construct() {
        $this->service = new ServiceUpdateService();
    }

    public function start(int $id): void 
    {
        $type = ControllerUtils::getPost("type");
        $price = ControllerUtils::getPost("price");

        $this->service->update($type, $price, $id);
    }
}
