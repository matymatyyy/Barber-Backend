<?php 

use Src\Service\TurnConfigDay\TurnConfigDayFinderService;

final readonly class TurnConfigDayGetController {
    private TurnConfigDayFinderService $service;

    public function __construct() {
        $this->service = new TurnConfigDayFinderService();
    }

    public function start(int $id): void 
    {
        $turnConfigDay = $this->service->find($id);
     
        echo json_encode([
            'id' => $turnConfigDay->id(),
            'turnConfigId' => $turnConfigDay->turnConfigId(),
            'day' => $turnConfigDay->day(),
            'hourBegin' => $turnConfigDay->hourBegin(),
            'hourEnd' => $turnConfigDay->hourEnd(),
            'turnTime' => $turnConfigDay->turnTime()
        ]);
    }
}
