<?php 

use Src\Utils\ControllerUtils;
use Src\Service\Client\ClientLoginService;

final readonly class ClientLoginController {
    private ClientLoginService $service;

    public function __construct() {
        $this->service = new ClientLoginService();
    }

    public function start(): void 
    {
        $email = ControllerUtils::getPost("email");
        $password = ControllerUtils::getPost("password");
        
        $client = $this->service->login($email, $password);
     
        echo json_encode([
            "token" => $client->token(),
        ]);
    }
}
