<?php 

declare(strict_types = 1);

namespace Src\Service\Client;

use Src\Model\Client\ClientModel;

final readonly class ClientUpdaterService {

    private ClientModel $model;
    private ClientFinderService $finder;

    public function __construct() 
    {
        $this->model = new ClientModel();
        $this->finder = new ClientFinderService();
    }

    public function update(
        string $name, 
        string $email,
        string $password,
        int $dni, 
        string $cellphone,
        int $id
    ): void 
    {
        $client = $this->finder->find($id);

        $client->modify(
            $name,
            $email, 
            $password, 
            $dni, 
            $cellphone, 
            );

        $this->model->update($client);
    }

}

