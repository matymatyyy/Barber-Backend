<?php 

declare(strict_types = 1);

namespace Src\Service\Client;

use Src\Model\Client\ClientModel;

final readonly class ClientDeleterService {

    private ClientModel $model;
    private ClientFinderService $finder;

    public function __construct() 
    {
        $this->model = new ClientModel();
        $this->finder = new ClientFinderService();
    }

    public function delete(
        int $id
    ): void 
    {
        $client = $this->finder->find($id);

        $this->model->delete($client->id());
    }
}

