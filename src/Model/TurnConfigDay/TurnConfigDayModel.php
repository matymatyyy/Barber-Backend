<?php 

namespace Src\Model\TurnConfigDay;

use Src\Model\DatabaseModel;
use Src\Entity\TurnConfigDay\TurnConfigDay;

final readonly class TurnConfigDayModel extends DatabaseModel {

    public function find(int $id): ?TurnConfigDay
    {
        $query = <<<SELECT_QUERY
                    SELECT
                        D.id,
                        D.id_turns_config,
                        D.id_client,
                        D.day,
                        D.hour_begin,
                        D.hour_end,
                        D.turn_time
                    FROM
                        turns_config_day D
                    WHERE
                        D.id = :id
                SELECT_QUERY;

        $parameters = [
            'id' => $id
        ];

        $result = $this->primitiveQuery($query, $parameters);
        
        return $this->toTurnConfigDay($result[0] ?? null);
    }

    /** @return TurnConfigDay[] */
    public function search(): array
    {
        $query = <<<SELECT_QUERY
                    SELECT
                        D.id,
                        D.id_turns_config,
                        D.id_client,
                        D.day,
                        D.hour_begin,
                        D.hour_end,
                        D.turn_time
                    FROM 
                        turns_config_day D
                SELECT_QUERY;

        $primitiveResults = $this->primitiveQuery($query);

        $objectResults = [];
        
        foreach ($primitiveResults as $primitiveResult) {
            $objectResults[] = $this->toTurnConfigDay($primitiveResult);
        }

        return $objectResults;
    }

    public function insert(TurnConfigDay $turnConfigDay): void
    {
        $query = <<<INSERT_QUERY
                        INSERT INTO
                            turns_config_day
                        (id,
                            id_turns_config,
                            day,
                            hour_begin,
                            hour_end,
                            turn_time)
                            VALUES
                        (
                            :id,
                            :id_turns_config,
                            :day,
                            :hour_begin,
                            :hour_end,
                            :turn_time)
                    INSERT_QUERY;

        $parameters = [
            "id" => $turnConfigDay->id(),
            "id_turns_config" => $turnConfigDay->turnConfigId(),
            'day' => $turnConfigDay->day(),
            'hour_begin' => $turnConfigDay->hourBegin()->format("Y-m-d H:i:s"),
            'hour_end' => $turnConfigDay->hourEnd()->format("Y-m-d H:i:s"),
            'turn_time' => $turnConfigDay->turnTime()->format("Y-m-d H:i:s")

        ];

        $this->primitiveQuery($query, $parameters);
    }

    public function update(TurnConfigDay $turnConfigDay): void
    {
        $query = <<<UPDATE_QUERY
                    UPDATE
                        turns_config_day
                    SET
                       id_turns_config = :id_turns_config,
                       id_client = :id_client,
                        day = :day,
                        hour_begin = :hour_begin,
                        hour_end = :hour_end,
                        turn_time = :turn_time
                    WHERE
                        id = :id
                    UPDATE_QUERY;
            
        $parameters = [
            "turnConfigId" => $turnConfigDay->turnConfigId(),
            'day' => $turnConfigDay->day(),
            'hourBegin' => $turnConfigDay->hourBegin(),
            'hourEnd' => $turnConfigDay->hourEnd(),
            'turnTime' => $turnConfigDay->turnTime(),
            "id" => $turnConfigDay->id()
        ];

        $this->primitiveQuery($query, $parameters);
    }

    public function delete(int $id): void
    {
        $query = <<<DELETE_QUERY
                    DELETE FROM
                        turns_config_day
                    WHERE
                        id = :id
                DELETE_QUERY;

        $parameters = [
            'id' => $id
        ];

        $this->primitiveQuery($query, $parameters);
    }

    private function toTurnConfigDay(?array $primitive): ?TurnConfigDay
    {
        if ($primitive === null) {
            return null;
        }

        return new TurnConfigDay(
            $primitive['id'],
            $primitive['turn_config_day'],
            $primitive['day'],
            $primitive['turn_time'],
            $primitive['hour_begin'],
            $primitive['hour_end'],
        );
    }
}