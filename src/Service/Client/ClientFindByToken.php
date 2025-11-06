<?php 

declare(strict_types = 1);

namespace Src\Service\Client;

use Src\Model\Client\ClientModel;
use Src\Entity\Client\Client;
use Src\Entity\Client\Exception\ClientNotFoundException;

final readonly class ClientFindByToken {

    private ClientModel $model;

    public function __construct() 
    {
        $this->model = new ClientModel();
    }

    public function find(string $token): Client 
    {
        $client = $this->model->findByToken($token);

        if ($client === null) {
            throw new ClientNotFoundException();
        }

        return $client;
    }
}
