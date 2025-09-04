<?php

use Src\Entity\Client\Client;
use Src\Service\Client\ClientsSearcherService;

final readonly class ClientsGetController {
    private ClientsSearcherService $service;

    public function __construct() {
        $this->service = new ClientsSearcherService();
    }

    public function start(): void
    {
        $clients = $this->service->search();

        echo json_encode([
            "data" => array_map($this->toResponse(), $clients),
        ]);
    }

    protected function toResponse(): Closure
    {
        return fn (Client $client): array => [
            'id' => $client->id(),
            'name' => $client->name(),
            'email' => $client->email(),
            'password' => $client->password(),
            'dni' => $client->dni(),
            'cellphone' => $client->cellphone()
        ];
    }
}