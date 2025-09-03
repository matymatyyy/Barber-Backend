<?php 

namespace Src\Model\Turn;

use Src\Model\DatabaseModel;
use Src\Entity\Turn\Turn;

final readonly class TurnModel extends DatabaseModel {

    public function find(int $id): ?Turn
    {
        $query = <<<SELECT_QUERY
                    SELECT
                        D.id,
                        D.id_barber,
                        D.id_client,
                        D.date,
                        D.hour_begin,
                        D.hour_end,
                        D.state
                    FROM
                        turns D
                    WHERE
                        D.id = :id
                SELECT_QUERY;

        $parameters = [
            'id' => $id
        ];

        $result = $this->primitiveQuery($query, $parameters);
        
        return $this->toTurn($result[0] ?? null);
    }

    /** @return Turn[] */
    public function search(): array
    {
        $query = <<<SELECT_QUERY
                    SELECT
                        D.id,
                        D.id_barber,
                        D.id_client,
                        D.date,
                        D.hour_begin,
                        D.hour_end,
                        D.state
                    FROM 
                        turns D
                SELECT_QUERY;

        $primitiveResults = $this->primitiveQuery($query);

        $objectResults = [];
        
        foreach ($primitiveResults as $primitiveResult) {
            $objectResults[] = $this->toTurn($primitiveResult);
        }

        return $objectResults;
    }

    public function insert(Turn $turn): void
    {
        $query = <<<INSERT_QUERY
                        INSERT INTO
                            turns
                        (id, id_barber, id_client, date, hour_begin, hour_end, state)
                            VALUES
                        (:id, :idBarber, :idClient, :date, :hourBegin, :hourEnd, :state)
                    INSERT_QUERY;

        $parameters = [
            "id" => $turn->id(),
            "idBarber" => $turn->barberId(),
            'idClient' => $turn->clientId(),
            'date' => $turn->date(),
            'hourBegin' => $turn->hourBegin(),
            'hourEnd' => $turn->hourEnd(),
            'state' => $turn->state()

        ];

        $this->primitiveQuery($query, $parameters);
    }

    public function update(Turn $turn): void
    {
        $query = <<<UPDATE_QUERY
                    UPDATE
                        turns
                    SET
                        id_barber = :idBarber,
                        id_client = :idClient, 
                        date = :date,
                        hour_begin = :hourBegin, 
                        hour_end = :hourEnd,
                        state = :state
                    WHERE
                        id = :id
                    UPDATE_QUERY;
            
        $parameters = [
            "idBarber" => $turn->barberId(),
            "idClient" => $turn->clientId(),
            'date' => $turn->date(),
            'hourBegin' => $turn->hourBegin(),
            'hourEnd' => $turn->hourEnd(),
            'state' => $turn->state(),
            "id" => $turn->id()
        ];

        $this->primitiveQuery($query, $parameters);
    }

    public function delete(int $id): void
    {
        $query = <<<DELETE_QUERY
                    DELETE FROM
                        turns   
                    WHERE
                        id = :id
                DELETE_QUERY;

        $parameters = [
            'id' => $id
        ];

        $this->primitiveQuery($query, $parameters);
    }

    private function toTurn(?array $primitive): ?Turn
    {
        if ($primitive === null) {
            return null;
        }

        return new Turn(
            $primitive['id'],
            $primitive['id_barber'],
            $primitive['id_client'],
            $primitive['date'],
            $primitive['hour_begin'],
            $primitive['hour_end'],
            $primitive['state']
        );
    }
}