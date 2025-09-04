<?php 

use Src\Utils\ControllerUtils;
use Src\Service\TurnConfig\TurnConfigUpdaterService;

final readonly class TurnConfigPutController {
    private TurnConfigUpdaterService $service;

    public function __construct() {
        $this->service = new TurnConfigUpdaterService();
    }

    public function start(int $id): void 
    {
        $barberId = ControllerUtils::getPost("barberId");

        $this->service->update(
              $id,
        $barberId,
        );
    }
}
