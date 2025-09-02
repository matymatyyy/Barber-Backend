<?php

use Src\Entity\Turn\Turn;
use Src\Service\Turn\TurnsSearcherService;

final readonly class TurnsGetController {
    private TurnsSearcherService $service;

    public function __construct() {
        $this->service = new TurnsSearcherService();
    }

    public function start(): void
    {
        $turns = $this->service->search();

        echo json_encode([
            "data" => array_map($this->toResponse(), $turns),
        ]);
    }

    protected function toResponse(): Closure
    {
        return fn (Turn $turn): array => [
            'id' => $turn->id(),
            'barberID' => $turn->barberId(),
            'clienteID' => $turn->clientId(),
            'date' => $turn->date(),
            'hourBegin' => $turn->hourBegin(),
            'hourEnd' => $turn->hourEnd(),
            'state' => $turn->state()
        ];
    }
}