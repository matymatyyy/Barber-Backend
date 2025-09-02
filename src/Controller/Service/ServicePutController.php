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
        $name = ControllerUtils::getPost("name");
        $code = ControllerUtils::getPost("code");

        $this->service->update($name, $code, $id);
    }
}
