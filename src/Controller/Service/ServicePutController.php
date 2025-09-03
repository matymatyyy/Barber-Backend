<?php 

use Src\Utils\ControllerUtils;
use Src\Service\Service\ServiceUpdaterService;

final readonly class ServicePutController {
    private ServiceUpdaterService $service;

    public function __construct() {
        $this->service = new ServiceUpdaterService();
    }

    public function start(int $id): void 
    {
        $type = ControllerUtils::getPost("type");
        $price = ControllerUtils::getPost("price");

        $this->service->update($type, $price, $id);
    }
}
