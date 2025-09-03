<?php 

declare(strict_types = 1);

namespace Src\Service\Client;

use Src\Model\Client\ClientModel;
use Src\Entity\Client\Client;

final readonly class ClientTokenGeneratorService {

    private ClientModel $model;

    public function __construct() 
    {
        $this->model = new ClientModel();
    }

    public function generate(Client $client): Client 
    {
        $client->generateToken();
        $this->model->updateToken($client);
        return $client;
    }

}

