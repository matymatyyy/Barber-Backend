<?php 

use Src\Service\Barber\BarberDeleterService;

final readonly class BarberDeleteController {
    private BarberDeleterService $service;

    public function __construct() {
        $this->service = new BarberDeleterService();
    }

    public function start(int $id): void 
    {
        $this->service->delete($id);
    }
}
