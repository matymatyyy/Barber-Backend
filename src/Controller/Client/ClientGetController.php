<?php 

use Src\Middleware\AuthMiddleware;
use Src\Service\Client\ClientFinderService;

final readonly class ClientGetController extends AuthMiddleware {
    private ClientFinderService $service;

    public function __construct() {
        parent::__construct();
        $this->service = new ClientFinderService();
    }

    public function start(int $id): void 
    {
        $client = $this->service->find($id);
     
        echo json_encode([
            'id' => $client->id(),
            'name' => $client->name(),
            'email' => $client->email(),
            'password' => $client->password(),
            'dni' => $client->dni(),
            'cellphone' => $client->cellphone()
        ]);
    }
}
