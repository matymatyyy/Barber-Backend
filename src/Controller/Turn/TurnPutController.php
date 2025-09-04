<?php 

use Src\Utils\ControllerUtils;
use Src\Service\Turn\TurnUpdaterService;

final readonly class TurnPutController {
    private TurnUpdaterService $service;

    public function __construct() {
        $this->service = new TurnUpdaterService();
    }

    public function start(int $id): void 
    {
        $barberId = ControllerUtils::getPost("barberId");
        $clientId = ControllerUtils::getPost("clientId");
        $date = ControllerUtils::getPost("date");
        $hourBegin = ControllerUtils::getPost("hourBegin");
        $hourEnd = ControllerUtils::getPost("hourEnd");
        $state = ControllerUtils::getPost("state");

        $date = new DateTime($date);
        $hourBegin = new DateTime( $hourBegin);
        $hourEnd   = new DateTime( $hourEnd);

        $this->service->update(
              $id,
        $barberId,
        $clientId,
            $date,
       $hourBegin,
         $hourEnd,
           $state
        );
    }
}
