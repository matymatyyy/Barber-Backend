<?php 

namespace Src\Infrastructure\Database;

use PDO;
use PDOException;

final class Client {

    /** @var PDO[] $activeClients */
    private static array $activeClients = [];

    public function connect(): PDO
    {
        $client = $this->client();

        if ($client === null) {
            $client = $this->connectClient();
        }

        return $client;
    }

    private function client(): ?PDO
    {
        return self::$activeClients[$_ENV['MYSQL_ROOT_USER']] ?? null;
    }


    private function connectClient(): PDO
    {
        try {
            $conn = new PDO(
                $this->generateUrl(),
                $_ENV['MYSQL_ROOT_USER'],
                $_ENV['MYSQL_ROOT_PASSWORD']
            );
            
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            self::$activeClients[$_ENV['MYSQL_ROOT_USER']] = $conn;

            return $conn;
        } catch (PDOException $e) {
            echo "Hubo un error en la base de datos ".$e->getMessage();
            exit();
        }
    }

    private function generateUrl(): string
    {
        return sprintf(
            '%s:host=%s;dbname=%s',
            $_ENV['MYSQL_TYPE'],
            sprintf('%s:%s', $_ENV['MYSQL_HOST'], $_ENV['MYSQL_PORT']),
            $_ENV['MYSQL_DATABASE']
        );
    }
}