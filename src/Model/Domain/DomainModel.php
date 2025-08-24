<?php 

namespace Src\Model\Domain;

use Src\Model\DatabaseModel;
use Src\Entity\Domain\Domain;

final readonly class DomainModel extends DatabaseModel {

    public function find(int $id): ?Domain
    {
        $query = <<<SELECT_QUERY
                    SELECT
                        D.id,
                        D.name,
                        D.code
                    FROM
                        domains D
                    WHERE
                        D.id = :id
                SELECT_QUERY;

        $parameters = [
            'id' => $id
        ];

        $result = $this->primitiveQuery($query, $parameters);
        
        return $this->toDomain($result[0] ?? null);
    }

    /** @return Domain[] */
    public function search(): array
    {
        $query = <<<SELECT_QUERY
                    SELECT
                        D.id,
                        D.name,
                        D.code
                    FROM 
                        domains D
                SELECT_QUERY;

        $primitiveResults = $this->primitiveQuery($query);

        $objectResults = [];
        
        foreach ($primitiveResults as $primitiveResult) {
            $objectResults[] = $this->toDomain($primitiveResult);
        }

        return $objectResults;
    }

    public function insert(Domain $domain): void
    {
        $query = <<<INSERT_QUERY
                        INSERT INTO
                            domains
                        (name, code)
                            VALUES
                        (:name, :code)
                    INSERT_QUERY;

        $parameters = [
            "name" => $domain->name(),
            "code" => $domain->code()
        ];

        $this->primitiveQuery($query, $parameters);
    }

    public function update(Domain $domain): void
    {
        $query = <<<UPDATE_QUERY
                    UPDATE
                        domains
                    SET
                        name = :name,
                        code = :code
                    WHERE
                        id = :id
                    UPDATE_QUERY;
            
        $parameters = [
            "name" => $domain->name(),
            "code" => $domain->code(),
            "id" => $domain->id()
        ];

        $this->primitiveQuery($query, $parameters);
    }

    private function toDomain(?array $primitive): ?Domain
    {
        if ($primitive === null) {
            return null;
        }

        return new Domain(
            $primitive['id'],
            $primitive['name'],
            $primitive['code']
        );
    }
}