<?php 

namespace Src\Model;

use PDO;
use Src\Infrastructure\Database\Client;

readonly class DatabaseModel {
    
    private PDO $conn;

    public function __construct() {
        $databaseObject = new Client();
        $this->conn = $databaseObject->connect();
    }

    public function primitiveQuery(
        string $query,
        array $parameters = []
    ): array 
    {
        $stmt = $this->conn->prepare($query);
        $stmt->execute($parameters);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}