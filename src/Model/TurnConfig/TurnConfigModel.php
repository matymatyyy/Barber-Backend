<?php 

namespace Src\Model\TurnConfig;

use Src\Model\DatabaseModel;
use Src\Entity\TurnConfig\TurnConfig;

final readonly class TurnConfigModel extends DatabaseModel {

    public function find(int $id): ?TurnConfig
    {
        $query = <<<SELECT_QUERY
                    SELECT
                        D.id,
                        D.id_barber
                    FROM
                        turns_config D
                    WHERE
                        D.id = :id
                SELECT_QUERY;

        $parameters = [
            'id' => $id
        ];

        $result = $this->primitiveQuery($query, $parameters);
        
        return $this->toTurnConfig($result[0] ?? null);
    }

    /** @return TurnConfig[] */
    public function search(): array
    {
        $query = <<<SELECT_QUERY
                    SELECT
                        D.id,
                        D.id_barber
                    FROM 
                        turns_config D
                SELECT_QUERY;

        $primitiveResults = $this->primitiveQuery($query);

        $objectResults = [];
        
        foreach ($primitiveResults as $primitiveResult) {
            $objectResults[] = $this->toTurnConfig($primitiveResult);
        }

        return $objectResults;
    }

    public function insert(TurnConfig $turnConfig): void
    {
        $query = <<<INSERT_QUERY
                        INSERT INTO
                            turns_config
                        (id, id_barber)
                            VALUES
                        (:id, :idBarber)
                    INSERT_QUERY;

        $parameters = [
            "id" => $turnConfig->id(),
            "idBarber" => $turnConfig->barberId(),
        ];

        $this->primitiveQuery($query, $parameters);
    }

    public function update(TurnConfig $turnConfig): void
    {
        $query = <<<UPDATE_QUERY
                    UPDATE
                        turns_config
                    SET
                        id_barber = :idBarber
                    WHERE
                        id = :id
                    UPDATE_QUERY;
            
        $parameters = [
            "idBarber" => $turnConfig->barberId(),
            "id" => $turnConfig->id()
        ];

        $this->primitiveQuery($query, $parameters);
    }

    public function delete(int $id): void
    {
        $query = <<<DELETE_QUERY
                    Delete FROM
                        turns_config D
                    WHERE
                        D.id = :id
                DELETE_QUERY;

        $parameters = [
            'id' => $id
        ];

        $this->primitiveQuery($query, $parameters);
    }

    private function toTurnConfig(?array $primitive): ?TurnConfig
    {
        if ($primitive === null) {
            return null;
        }

        return new TurnConfig(
            $primitive['id'],
            $primitive['id_barber']
        );
    }
}