<?php 

use Src\Utils\ControllerUtils;
use Src\Service\Barber\BarberLoginService;

final readonly class BarberLoginController {
    private BarberLoginService $service;

    public function __construct() {
        $this->service = new BarberLoginService();
    }

    public function start(): void 
    {
        $email = ControllerUtils::getPost("email");
        $password = ControllerUtils::getPost("password");
        
        $barber = $this->service->login($email, $password);
     
        echo json_encode([
            "token" => $barber->token(),
        ]);
    }
}
