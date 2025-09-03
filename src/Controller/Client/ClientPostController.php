<?php 

use src\Utils\ControllerUtils;
use Src\Service\Client\ClientCreatorService;

final readonly class ClientPostController {
    private ClientCreatorService $service;

    public function __construct() {
        $this->service = new ClientCreatorService();
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
