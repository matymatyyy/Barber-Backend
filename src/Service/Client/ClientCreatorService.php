<?php 

declare(strict_types = 1);

namespace Src\Service\Client;

use Src\Model\Client\ClientModel;
use Src\Entity\Client\Client;

final readonly class ClientCreatorService {

    private ClientModel $model;

    public function __construct() 
    {
        $this->model = new ClientModel();
    }

    public function create(
        string $name, 
        string $email, 
        string $password,
        int $dni,
        string $cellphone): void 
    {
        $client = Client::create(
        $name, 
        $email, 
        $password,
        $dni,
        $cellphone);

        $this->model->insert($client);
    }
}

