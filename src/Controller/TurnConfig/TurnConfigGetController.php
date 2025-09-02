<?php 

use Src\Middleware\AuthMiddleware;
use Src\Service\TurnConfig\TurnConfigFinderService;

final readonly class TurnConfigGetController extends AuthMiddleware {
    private TurnConfigFinderService $service;

    public function __construct() {
        parent::__construct();
        $this->service = new TurnConfigFinderService();
    }

    public function start(int $id): void 
    {
        $turnConfig = $this->service->find($id);
     
        echo json_encode([
            'id' => $turnConfig->id(),
            'barberID' => $turnConfig->barberId()
        ]);
    }
}
