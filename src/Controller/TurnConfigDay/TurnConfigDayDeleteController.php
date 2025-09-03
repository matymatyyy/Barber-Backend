<?php 

use Src\Service\TurnConfigDay\TurnConfigDayDeleterService;

final readonly class TurnConfigDayDeleteController {
    private TurnConfigDayDeleterService $service;

    public function __construct() {
        $this->service = new TurnConfigDayDeleterService();
    }

    public function start(int $id): void 
    {
        $this->service->delete($id);
    }
}
