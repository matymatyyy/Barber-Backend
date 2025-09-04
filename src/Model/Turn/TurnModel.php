<?php 

namespace Src\Model\Turn;

use DateTime;
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
                        (id_barber, id_client, date, hour_begin, hour_end, state)
                            VALUES
                        (:idBarber, :idClient, :date, :hourBegin, :hourEnd, :state)
                    INSERT_QUERY;

        $parameters = [
            "idBarber" => $turn->barberId(),
            'idClient' => $turn->clientId(),
            'date' => $turn->date()->format('Y-m-d H:i:s'),
            'hourBegin' => $turn->hourBegin()->format('Y-m-d H:i:s'),
            'hourEnd' => $turn->hourEnd()->format('Y-m-d H:i:s'),
            'state' => $turn->state() ? 1 : 0

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
            'date' => $turn->date()->format('Y-m-d H:i:s'),
            'hourBegin' => $turn->hourBegin()->format('Y-m-d H:i:s'),
            'hourEnd' => $turn->hourEnd()->format('Y-m-d H:i:s'),
            'state' => $turn->state() ? 1 : 0,
            "id" => $turn->id() 
        ];

        $this->primitiveQuery($query, $parameters);
    }

    public function delete(int $id): void
    {
        $query = <<<DELETE_QUERY
                    delete FROM
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

        $date = new DateTime($primitive['date']);
        $hourBegin = new DateTime($primitive['hour_begin']);
        $hourEnd = new DateTime($primitive['hour_end']);

        return new Turn(
            $primitive['id'],
            $primitive['id_barber'],
            $primitive['id_client'],
            $date,
            $hourBegin,
            $hourEnd,
            $primitive['state']
        );
    }
}