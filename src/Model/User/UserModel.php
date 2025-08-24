<?php 

namespace Src\Model\User;

use DateTime;
use Src\Model\DatabaseModel;
use Src\Entity\User\User;

final readonly class UserModel extends DatabaseModel {

    public function findByEmailAndPassword(string $email, string $password): ?User
    {
        $query = <<<SELECT_QUERY
                    SELECT
                        U.*
                    FROM
                        users U
                    WHERE
                        U.email = :email
                SELECT_QUERY;

        $parameters = [
            'email' => $email,
        ];

        $result = $this->primitiveQuery($query, $parameters);
        
        $user = $this->toUser($result[0] ?? null); 

        if ($user === null) {
            return null;
        }

        if (password_verify($password, $user->password())) {
            return $user;
        }

        return null;
    }

    public function findByToken(string $token): ?User
    {
        $query = <<<SELECT_QUERY
                    SELECT
                        U.*
                    FROM
                        users U
                    WHERE
                        U.token = :token AND :date <= U.token_auth_date
                SELECT_QUERY;

        $parameters = [
            'token' => $token,
            'date' => date("Y-m-d H:i:s")
        ];

        $result = $this->primitiveQuery($query, $parameters);
        
        return $this->toUser($result[0] ?? null);
    }

    public function insert(User $user): void
    {
        $query = <<<INSERT_QUERY
                INSERT INTO users
                (name, email, password, token, token_auth_date)
                VALUES
                (:name, :email, :password, :token, :tokenAuthDate)
                INSERT_QUERY;

        $parameters = [
            "name" => $user->name(),
            "email" => $user->email(),
            "password" => $user->password(),
            "token" => $user->token(),
            "tokenAuthDate" => $user->tokenAuthDate()?->format("Y-m-d H:i:s")
        ];
        
        $this->primitiveQuery($query, $parameters);
    }

    public function update(User $user): void
    {
        $query = <<<SELECT_QUERY
                    UPDATE
                        users
                    SET
                        token = :token,
                        token_auth_date = :date
                    WHERE
                        id = :id
                SELECT_QUERY;

        $parameters = [
            'token' => $user->token(),
            'date' => $user->tokenAuthDate()->format("Y-m-d H:i:s"),
            'id' => $user->id()
        ];

        $this->primitiveQuery($query, $parameters);
    }

    private function toUser(?array $primitive): ?User
    {
        if ($primitive === null) {
            return null;
        }

        return new User(
            $primitive['id'],
            $primitive['name'],
            $primitive['email'],
            $primitive['password'],
            $primitive['token'],
            empty($primitive['token_auth_date']) ? null : new DateTime($primitive['token_auth_date']),
        );
    }
}