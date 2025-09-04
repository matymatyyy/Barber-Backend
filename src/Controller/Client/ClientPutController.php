<?php 

use Src\Utils\ControllerUtils;
use Src\Service\Client\ClientUpdaterService;

final readonly class ClientPutController {
    private ClientUpdaterService $service;

    public function __construct() {
        $this->service = new ClientUpdaterService();
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
