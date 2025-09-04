<?php 

declare(strict_types = 1);

namespace Src\Service\Client;

use Src\Model\Client\ClientModel;
use Src\Entity\Client\Client;
use Src\Entity\Client\Exception\ClientNotAuthorizedException;

final readonly class ClientTokenValidatorService {

    private ClientModel $model;

    public function __construct() 
    {
        $this->model = new ClientModel();
    }

    public function validate(string $token): Client 
    {
        $client = $this->model->findByToken($token);

        if ($client === null) {
            throw new ClientNotAuthorizedException();
        }

        return $client;
    }

}

