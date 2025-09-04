<?php 

use Src\Utils\ControllerUtils;
//use Src\Middleware\AuthMiddleware;
use Src\Service\TurnConfigDay\TurnConfigDayCreatorService;

final readonly class TurnConfigDayPostController /*extends AuthMiddleware*/ {
    private TurnConfigDayCreatorService $service;

    public function __construct() {
        $this->service = new TurnConfigDayCreatorService();
    }

    public function start(): void 
    {
        $turnConfigId = ControllerUtils::getPost("turnConfigId");
        $day = ControllerUtils::getPost("day");
        $turnTime  = ControllerUtils::getPost("turnTime");
        $hourBegin = ControllerUtils::getPost("hourBegin");
        $hourEnd = ControllerUtils::getPost("hourEnd");
       

        $this->service->create(
            $turnConfigId,
       $day,
         new DateTime($turnTime),
           new DateTime($hourBegin),
        new DateTime($hourEnd),
        );
    }
}
