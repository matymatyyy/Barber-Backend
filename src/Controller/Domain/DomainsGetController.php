<?php

use Src\Entity\Domain\Domain;
use Src\Service\Domain\DomainsSearcherService;

final readonly class DomainsGetController {
    private DomainsSearcherService $service;

    public function __construct() {
        $this->service = new DomainsSearcherService();
    }

    public function start(): void
    {
        $domains = $this->service->search();

        echo json_encode([
            "data" => array_map($this->toResponse(), $domains),
        ]);
    }

    protected function toResponse(): Closure
    {
        return fn (Domain $domain): array => [
            'id' => $domain->id(),
            'name' => $domain->name(),
            'code' => $domain->code(),
        ];
    }
}