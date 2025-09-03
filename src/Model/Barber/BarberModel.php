<?php 

namespace Src\Model\Barber;

use DateTime;
use Src\Model\DatabaseModel;
use Src\Entity\Barber\Barber;

final readonly class BarberModel extends DatabaseModel {

    public function findByEmailAndPassword(string $email, string $password): ?Barber
    {
        $query = <<<SELECT_QUERY
                    SELECT
                        B.*
                    FROM
                        barbers B
                    WHERE
                        B.email = :email
                SELECT_QUERY;

        $parameters = [
            'email' => $email,
        ];

        $result = $this->primitiveQuery($query, $parameters);
        
        $barber = $this->toBarber($result[0] ?? null); 

        if ($barber === null) {
            return null;
        }

        if (password_verify($password, $barber->password())) {
            return $barber;
        }

        return null;
    }

    public function findByToken(string $token): ?Barber
    {
        $query = <<<SELECT_QUERY
                    SELECT
                        B.*
                    FROM
                        barbers B
                    WHERE
                        B.token = :token AND :date <= B.token_auth_date
                SELECT_QUERY;

        $parameters = [
            'token' => $token,
            'date' => date("Y-m-d H:i:s")
        ];

        $result = $this->primitiveQuery($query, $parameters);
        
        return $this->toBarber($result[0] ?? null);
    }

    public function find(int $id): ?Barber
    {
        $query = <<<SELECT_QUERY
                    SELECT
                        B.id,
                        B.name,
                        B.email,
                        B.password,
                        B.dni,
                        B.cellphone,
                        B.token,
                        B.token_auth_date
                    FROM
                        barbers B
                    WHERE
                        B.id = :id
                SELECT_QUERY;

        $parameters = [
            'id' => $id
        ];

        $result = $this->primitiveQuery($query, $parameters);
        
        return $this->toBarber($result[0] ?? null);
    }

    /** @return Barber[] */
    public function search(): array
    {
        $query = <<<SELECT_QUERY
                    SELECT
                        B.id,
                        B.name,
                        B.email,
                        B.password,
                        B.dni,
                        B.cellphone,
                        B.token,
                        B.token_auth_date
                    FROM 
                        barbers B
                SELECT_QUERY;

        $primitiveResults = $this->primitiveQuery($query);

        $objectResults = [];
        
        foreach ($primitiveResults as $primitiveResult) {
            $objectResults[] = $this->toBarber($primitiveResult);
        }

        return $objectResults;
    }

    public function insert(Barber $barber): void
    {
        $query = <<<INSERT_QUERY
                INSERT INTO barbers
                (name, email, password, dni, cellphone, token, token_auth_date)
                VALUES
                (:name, :email, :password, :dni, :cellphone, :token, :tokenAuthDate)
                INSERT_QUERY;

        $parameters = [
            "name" => $barber->name(),
            "email" => $barber->email(),
            "password" => $barber->password(),
            "dni" => $barber->dni(),
            "cellphone" => $barber->cellphone(),
            "token" => $barber->token(),
            "tokenAuthDate" => $barber->tokenAuthDate()?->format("Y-m-d H:i:s")
        ];
        
        $this->primitiveQuery($query, $parameters);
    }

    public function updateToken(Barber $barber): void
    {
        $query = <<<SELECT_QUERY
                    UPDATE
                        barbers
                    SET
                        token = :token,
                        token_auth_date = :date
                    WHERE
                        id = :id
                SELECT_QUERY;

        $parameters = [
            'token' => $barber->token(),
            'date' => $barber->tokenAuthDate()->format("Y-m-d H:i:s"),
            'id' => $barber->id()
        ];

        $this->primitiveQuery($query, $parameters);
    }

    public function update(Barber $barber): void
    {
        $query = <<<SELECT_QUERY
                    UPDATE
                        barbers
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
            'name' => $barber->name(),
            'email' => $barber->email(),
            'password' => $barber->password(),
            'dni' => $barber->dni(),
            'cellphone' => $barber->cellphone(),
            'id' => $barber->id()
        ];

        $this->primitiveQuery($query, $parameters);
    }

    public function delete(int $id): void
    {
        $query = <<<DELETE_QUERY
                    DELETE FROM
                        barbers 
                    WHERE
                        id = :id
                DELETE_QUERY;

        $parameters = [
            'id' => $id
        ];

        $this->primitiveQuery($query, $parameters);
    }

    private function toBarber(?array $primitive): ?Barber
    {
        if ($primitive === null) {
            return null;
        }

        return new Barber(
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