<?php 

use Src\Service\Turn\TurnDeleterService;

final readonly class TurnDeleteController {
    private TurnDeleterService $service;

    public function __construct() {
        $this->service = new TurnDeleterService();
    }

    public function start(int $id): void 
    {
        $this->service->delete($id);
    }
}
