<?php

use Src\Utils\ControllerUtils;
use Src\Service\Turn\TurnReservationService;

readonly class TurnReservationController{
    private TurnReservationService $service;

    public function __construct() {
        $this->service = new TurnReservationService();
    }

    public function start(): void 
    {
        $id = ControllerUtils::getPost("id");
        $idClient = ControllerUtils::getPost("id_client");

        $this->service->reservation(
              $id,
              $idClient
        );
    }
}
