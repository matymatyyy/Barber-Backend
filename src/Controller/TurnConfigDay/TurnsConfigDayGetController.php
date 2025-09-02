<?php

use Src\Entity\TurnConfigDay\TurnConfigDay;
use Src\Service\TurnConfigDay\TurnsConfigDaySearcherService;

final readonly class TurnsConfigDayGetController {
    private TurnsConfigDaySearcherService $service;

    public function __construct() {
        $this->service = new TurnsConfigDaySearcherService();
    }

    public function start(): void
    {
        $turnsConfigDay = $this->service->search();

        echo json_encode([
            "data" => array_map($this->toResponse(), $turnsConfigDay),
        ]);
    }

    protected function toResponse(): Closure
    {
        return fn (TurnConfigDay $turnConfigDay): array => [
            "turnConfigId" => $turnConfigDay->turnConfigId(),
            'day' => $turnConfigDay->day(),
            'hourBegin' => $turnConfigDay->hourBegin(),
            'hourEnd' => $turnConfigDay->hourEnd(),
            'turnTime' => $turnConfigDay->turnTime(),
            "id" => $turnConfigDay->id()
        ];
    }
}