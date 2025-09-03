<?php 

declare(strict_types = 1);

namespace Src\Service\Client;

use Src\Model\Client\ClientModel;
use Src\Entity\Client\Client;
use Src\Entity\Client\Exception\ClientNotFoundException;

final readonly class ClientFinderService {

    private ClientModel $model;

    public function __construct() 
    {
        $this->model = new ClientModel();
    }

    public function find(int $id): Client 
    {
        $client = $this->model->find($id);

        if ($client === null) {
            throw new ClientNotFoundException();
        }

        return $client;
    }
}
