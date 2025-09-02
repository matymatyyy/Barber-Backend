<?php

use Src\Entity\Service\Service;
use Src\Service\Service\ServicesSearcherService;

final readonly class ServicesGetController {
    private ServicesSearcherService $service;

    public function __construct() {
        $this->service = new ServicesSearcherService();
    }

    public function start(): void
    {
        $services = $this->service->search();

        echo json_encode([
            "data" => array_map($this->toResponse(), $services),
        ]);
    }

    protected function toResponse(): Closure
    {
        return fn (Service $service): array => [
            'id' => $service->id(),
            'type' => $service->type(),
            'price' => $service->price()
        ];
    }
}