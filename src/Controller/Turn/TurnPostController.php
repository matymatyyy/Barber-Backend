<?php 

use Src\Utils\ControllerUtils;
use Src\Middleware\AuthMiddleware;
use Src\Service\Turn\TurnCreatorService;

final readonly class TurnPostController extends AuthMiddleware {
    private TurnCreatorService $service;

    public function __construct() {
        $this->service = new TurnCreatorService();
    }

    public function start(): void 
    {
        $date = ControllerUtils::getPost("date");
        $hourBegin = ControllerUtils::getPost("hourBegin");
        $hourEnd = ControllerUtils::getPost("hourEnd");
        $state = ControllerUtils::getPost("state");
        $barberId  = ControllerUtils::getPost("barberId ");
        $clientId  = ControllerUtils::getPost("clientId ");

        $this->service->create(
            $date,
       $hourBegin,
         $hourEnd,
           $state,
        $barberId,
        $clientId
        );
    }
}
