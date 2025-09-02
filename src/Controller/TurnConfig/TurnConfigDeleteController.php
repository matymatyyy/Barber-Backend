<?php 

use Src\Service\TurnConfig\TurnConfigDeleterService;

final readonly class TurnConfigDeleteController {
    private TurnConfigDeleterService $service;

    public function __construct() {
        $this->service = new TurnConfigDeleterService();
    }

    public function start(int $id): void 
    {
        $this->service->delete($id);
    }
}
