<?php 

use src\Utils\ControllerUtils;
use Src\Service\Barber\BarberCreatorService;

final readonly class BarberPostController {
    private BarberCreatorService $service;

    public function __construct() {
        $this->service = new BarberCreatorService();
    }

    public function start(): void 
    {
        $name = ControllerUtils::getPost("name");
        $email = ControllerUtils::getPost("email");
        $password = ControllerUtils::getPost("password");
        $dni = ControllerUtils::getPost("dni");
        $cellphone = ControllerUtils::getPost("cellphone");

        $this->service->create($name, $email, $password, $dni, $cellphone);
    }
}
