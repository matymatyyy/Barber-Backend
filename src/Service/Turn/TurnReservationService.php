<?php 

declare(strict_types = 1);

namespace Src\Service\Turn;

use Src\Service\Client\ClientFinderService;

final readonly class TurnReservationService {

    private TurnUpdaterService $service;
    private TurnFinderService $finder;
    private ClientFinderService $clientFinderService;

    public function __construct()
    {
        $this->service = new TurnUpdaterService();
        $this->finder = new TurnFinderService();
        $this->clientFinderService = new ClientFinderService();
    }

    public function reservation(
        int $id,
        int $clientId,
    ): void
    {
        $turn = $this->finder->find($id);

        $client = $this->clientFinderService->find($clientId);

        $this->service->update(
            $turn->id(),
            $turn->barberId(),
            $client->id(),
            $turn->date(),
            $turn->hourBegin(),
            $turn->hourEnd(),
            !$turn->state(),
        );
    }
}
