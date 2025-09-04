<?php 

use Src\Utils\ControllerUtils;
use Src\Service\Barber\BarberUpdaterService;

final readonly class BarberPutController {
    private BarberUpdaterService $service;

    public function __construct() {
        $this->service = new BarberUpdaterService();
    }

    public function start(int $id): void 
    {
        $name = ControllerUtils::getPost("name");
        $email = ControllerUtils::getPost("email");
        $password = ControllerUtils::getPost("password");
        $dni = ControllerUtils::getPost("dni");
        $cellphone = ControllerUtils::getPost("cellphone");

        $this->service->update(
            $name,
            $email, 
            $password, 
            $dni, 
            $cellphone, 
            $id);
    }
}
