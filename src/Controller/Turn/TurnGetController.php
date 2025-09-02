<?php 

use Src\Middleware\AuthMiddleware;
use Src\Service\Turn\TurnFinderService;

final readonly class TurnGetController extends AuthMiddleware {
    private TurnFinderService $service;

    public function __construct() {
        parent::__construct();
        $this->service = new TurnFinderService();
    }

    public function start(int $id): void 
    {
        $turn = $this->service->find($id);
     
        echo json_encode([
            'id' => $turn->id(),
            'barberID' => $turn->barberId(),
            'clienteID' => $turn->clientId(),
            'date' => $turn->date(),
            'hourBegin' => $turn->hourBegin(),
            'hourEnd' => $turn->hourEnd(),
            'state' => $turn->state()
        ]);
    }
}
