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
        $hourBegin = ControllerUtils::getPost("hourBegin");
        $hourEnd = ControllerUtils::getPost("hourEnd");
        $day = ControllerUtils::getPost("day");
        $turnTime  = ControllerUtils::getPost("turnTime ");

        $this->service->update(
              $id,
        $turnConfigId,
        $day,
            $turnTime,
       $hourBegin,
         $hourEnd
        );
    }
}
