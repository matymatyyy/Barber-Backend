<?php 

use Src\Service\Turn\TurnFinderService;

final readonly class TurnGetController{
    private TurnFinderService $service;

    public function __construct() {
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
