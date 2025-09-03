<?php 

namespace Src\Service\Client;

use Src\Entity\Client\Client;
use Src\Model\Client\ClientModel;

final readonly class ClientsSearcherService {
    private ClientModel $clientModel;

    public function __construct() {
        $this->clientModel = new ClientModel();
    }

    /** @return Client[] */
    public function search(): array
    {
        return $this->clientModel->search();
    }
}