<?php

use Src\Entity\Barber\Barber;
use Src\Service\Barber\BarbersSearcherService;

final readonly class BarbersGetController {
    private BarbersSearcherService $service;

    public function __construct() {
        $this->service = new BarbersSearcherService();
    }

    public function start(): void
    {
        $barbers = $this->service->search();

        echo json_encode([
            "data" => array_map($this->toResponse(), $barbers),
        ]);
    }

    protected function toResponse(): Closure
    {
        return fn (Barber $barber): array => [
            'id' => $barber->id(),
            'name' => $barber->name(),
            'email' => $barber->email(),
            'password' => $barber->password(),
            'dni' => $barber->dni(),
            'cellphone' => $barber->cellphone()
        ];
    }
}