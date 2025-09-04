<?php 

namespace Src\Model\Client;

use DateTime;
use Src\Model\DatabaseModel;
use Src\Entity\Client\Client;

final readonly class ClientModel extends DatabaseModel {

    public function findByEmailAndPassword(string $email, string $password): ?Client
    {
        $query = <<<SELECT_QUERY
                    SELECT
                        C.*
                    FROM
                        clients C
                    WHERE
                        C.email = :email
                SELECT_QUERY;

        $parameters = [
            'email' => $email,
        ];

        $result = $this->primitiveQuery($query, $parameters);
        
        $client = $this->toClient($result[0] ?? null); 

        if ($client === null) {
            return null;
        }

        if (password_verify($password, $client->password())) {
            return $client;
        }

        return null;
    }

    public function findByToken(string $token): ?Client
    {
        $query = <<<SELECT_QUERY
                    SELECT
                        C.*
                    FROM
                        clients C
                    WHERE
                        C.token = :token AND :date <= C.token_auth_date
                SELECT_QUERY;

        $parameters = [
            'token' => $token,
            'date' => date("Y-m-d H:i:s")
        ];

        $result = $this->primitiveQuery($query, $parameters);
        
        return $this->toClient($result[0] ?? null);
    }

    public function find(int $id): ?Client
    {
        $query = <<<SELECT_QUERY
                    SELECT
                        C.id,
                        C.name,
                        C.email,
                        C.password,
                        C.dni,
                        C.cellphone,
                        C.token,
                        C.token_auth_date
                    FROM
                        clients C
                    WHERE
                        C.id = :id
                SELECT_QUERY;

        $parameters = [
            'id' => $id
        ];

        $result = $this->primitiveQuery($query, $parameters);
        
        return $this->toClient($result[0] ?? null);
    }

    /** @return Client[] */
    public function search(): array
    {
        $query = <<<SELECT_QUERY
                    SELECT
                        C.id,
                        C.name,
                        C.email,
                        C.password,
                        C.dni,
                        C.cellphone,
                        C.token,
                        C.token_auth_date
                    FROM 
                        clients C
                SELECT_QUERY;

        $primitiveResults = $this->primitiveQuery($query);

        $objectResults = [];
        
        foreach ($primitiveResults as $primitiveResult) {
            $objectResults[] = $this->toClient($primitiveResult);
        }

        return $objectResults;
    }

    public function insert(Client $client): void
    {
        $query = <<<INSERT_QUERY
                INSERT INTO clients
                (name, email, password, dni, cellphone, token, token_auth_date)
                VALUES
                (:name, :email, :password, :dni, :cellphone, :token, :tokenAuthDate)
                INSERT_QUERY;

        $parameters = [
            "name" => $client->name(),
            "email" => $client->email(),
            "password" => $client->password(),
            "dni" => $client->dni(),
            "cellphone" => $client->cellphone(),
            "token" => $client->token(),
            "tokenAuthDate" => $client->tokenAuthDate()?->format("Y-m-d H:i:s")
        ];
        
        $this->primitiveQuery($query, $parameters);
    }

    public function updateToken(Client $client): void
    {
        $query = <<<SELECT_QUERY
                    UPDATE
                        clients
                    SET
                        token = :token,
                        token_auth_date = :date
                    WHERE
                        id = :id
                SELECT_QUERY;

        $parameters = [
            'token' => $client->token(),
            'date' => $client->tokenAuthDate()->format("Y-m-d H:i:s"),
            'id' => $client->id()
        ];

        $this->primitiveQuery($query, $parameters);
    }

    public function update(Client $client): void
    {
        $query = <<<SELECT_QUERY
                    UPDATE
                        clients
                    SET
                        name = :name,
                        email = :email,
                        password = :password,
                        dni = :dni,
                        cellphone = :cellphone
                    WHERE
                        id = :id
                SELECT_QUERY;

        $parameters = [
            'name' => $client->name(),
            'email' => $client->email(),
            'password' => $client->password(),
            'dni' => $client->dni(),
            'cellphone' => $client->cellphone(),
            'id' => $client->id()
        ];

        $this->primitiveQuery($query, $parameters);
    }

    public function delete(int $id): void
    {
        $query = <<<DELETE_QUERY
                    DELETE FROM
                        clients 
                    WHERE
                        id = :id
                DELETE_QUERY;

        $parameters = [
            'id' => $id
        ];

        $this->primitiveQuery($query, $parameters);
    }

    private function toClient(?array $primitive): ?Client
    {
        if ($primitive === null) {
            return null;
        }

        return new Client(
            $primitive['id'],
            $primitive['name'],
            $primitive['email'],
            $primitive['password'],
            $primitive['dni'],
            $primitive['cellphone'],
            $primitive['token'],
            empty($primitive['token_auth_date']) ? null : new DateTime($primitive['token_auth_date']),
        );
    }
}