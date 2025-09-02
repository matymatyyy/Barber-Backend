<?php 

namespace Src\Model\Service;

use Src\Model\DatabaseModel;
use Src\Entity\Service\Service;

final readonly class ServiceModel extends DatabaseModel {

    public function find(int $id): ?Service
    {
        $query = <<<SELECT_QUERY
                    SELECT
                        S.id,
                        S.type,
                        S.price
                    FROM
                        services S
                    WHERE
                        S.id = :id
                SELECT_QUERY;

        $parameters = [
            'id' => $id
        ];

        $result = $this->primitiveQuery($query, $parameters);
        
        return $this->toService($result[0] ?? null);
    }

    /** @return Service[] */
    public function search(): array
    {
        $query = <<<SELECT_QUERY
                    SELECT
                        S.id,
                        S.type,
                        S.price
                    FROM 
                        services S
                SELECT_QUERY;

        $primitiveResults = $this->primitiveQuery($query);

        $objectResults = [];
        
        foreach ($primitiveResults as $primitiveResult) {
            $objectResults[] = $this->toService($primitiveResult);
        }

        return $objectResults;
    }

    public function insert(Service $service): void
    {
        $query = <<<INSERT_QUERY
                        INSERT INTO
                            services
                        (price, type)
                            VALUES
                        (:price, :type)
                    INSERT_QUERY;

        $parameters = [
            "price" => $service->price(),
            "type" => $service->type()
        ];

        $this->primitiveQuery($query, $parameters);
    }

    public function update(Service $Service): void
    {
        $query = <<<UPDATE_QUERY
                    UPDATE
                        services
                    SET
                        price = :price,
                        type = :type
                    WHERE
                        id = :id
                    UPDATE_QUERY;
            
        $parameters = [
            "price" => $Service->price(),
            "type" => $Service->type(),
            "id" => $Service->id()
        ];

        $this->primitiveQuery($query, $parameters);
    }

    public function delete(int $id): void
    {
        $query = <<<DELETE_QUERY
                    Delete FROM
                        services S
                    WHERE
                        S.id = :id
                DELETE_QUERY;

        $parameters = [
            'id' => $id
        ];

        $this->primitiveQuery($query, $parameters);
    }

    private function toService(?array $primitive): ?Service
    {
        if ($primitive === null) {
            return null;
        }

        return new Service(
            $primitive['id'],
            $primitive['type'],
            $primitive['price']
        );
    }
}