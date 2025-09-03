<?php 

declare(strict_types = 1);

namespace Src\Service\Client;

use Src\Model\Client\ClientModel;
use Src\Entity\Client\Client;
use Src\Entity\Client\Exception\ClientNotFoundException;

final readonly class ClientLoginService {

    private ClientModel $model;
    private ClientTokenGeneratorService $tokenGenerator;

    public function __construct() 
    {
        $this->model = new ClientModel();
        $this->tokenGenerator = new ClientTokenGeneratorService();
    }

    public function login(string $email, string $password): Client 
    {
        $client = $this->model->findByEmailAndPassword($email, $password);

        if ($client === null) {
            throw new ClientNotFoundException();
        }

        $this->tokenGenerator->generate($client);

        return $client;
    }

}

