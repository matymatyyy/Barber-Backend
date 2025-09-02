<?php 

use Src\Service\Service\ServiceDeleterService;

final readonly class ServiceDeleteController {
    private ServiceDeleterService $service;

    public function __construct() {
        $this->service = new ServiceDeleterService();
    }

    public function start(int $id): void 
    {
        $this->service->delete($id);
    }
}
