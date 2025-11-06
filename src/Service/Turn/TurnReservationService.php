<?php 

declare(strict_types = 1);

namespace Src\Service\Turn;

use Src\Service\Client\ClientFindByToken;

final readonly class TurnReservationService {

    private TurnUpdaterService $service;
    private TurnFinderService $finder;
    private ClientFindByToken $clientFindByToken;

    public function __construct()
    {
        $this->service = new TurnUpdaterService();
        $this->finder = new TurnFinderService();
        $this->clientFindByToken = new ClientFindByToken();
    }

    public function reservation(
        int $id,
        string $token,
    ): void
    {
        $turn = $this->finder->find($id);

        $client = $this->clientFindByToken->find($token);

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
