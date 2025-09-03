<?php 

use Src\Utils\ControllerUtils;
use Src\Service\TurnConfigDay\TurnConfigDayUpdaterService;

final readonly class TurnConfigDayPutController {
    private TurnConfigDayUpdaterService $service;

    public function __construct() {
        $this->service = new TurnConfigDayUpdaterService();
    }

    public function start(int $id): void 
    {
        $turnConfigId = ControllerUtils::getPost("turnConfigId");
        $day = ControllerUtils::getPost("day");
        $hourBegin = ControllerUtils::getPost("hourBegin");
        $hourEnd = ControllerUtils::getPost("hourEnd");
        $turnTime  = ControllerUtils::getPost("turnTime ");

        $this->service->update(
              $id,
        $turnConfigId,
        $day,
       $hourBegin,
         $hourEnd,
         $turnTime
        );
    }
}
