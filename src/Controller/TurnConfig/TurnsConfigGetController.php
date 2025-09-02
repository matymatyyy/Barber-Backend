<?php

use Src\Entity\TurnConfig\TurnConfig;
use Src\Service\TurnConfig\TurnsConfigSearcherService;

final readonly class TurnsConfigGetController {
    private TurnsConfigSearcherService $service;

    public function __construct() {
        $this->service = new TurnsConfigSearcherService();
    }

    public function start(): void
    {
        $turnsConfig = $this->service->search();

        echo json_encode([
            "data" => array_map($this->toResponse(), $turnsConfig),
        ]);
    }

    protected function toResponse(): Closure
    {
        return fn (TurnConfig $turnConfig): array => [
            'id' => $turnConfig->id(),
            'barberID' => $turnConfig->barberId(),
        ];
    }
}