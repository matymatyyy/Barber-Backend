<?php

use Src\Service\Turn\TurnGenerateMonthService;

final readonly class TurnGenerateMonthController{

    private TurnGenerateMonthService $service;

    public function __construct() {
        $this->service = new TurnGenerateMonthService();
    }

    public function start(): void 
    {
        $this->service->generate();
    }
}
