<?php 

use Src\Middleware\AuthMiddleware;
use Src\Service\TurnConfigDay\TurnConfigDayFinderService;

final readonly class TurnConfigDayGetController extends AuthMiddleware {
    private TurnConfigDayFinderService $service;

    public function __construct() {
        parent::__construct();
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
