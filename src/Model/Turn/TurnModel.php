<?php 

namespace Src\Model\Turn;

use DateInterval;
use DateTime;
use Src\Model\DatabaseModel;
use Src\Entity\Turn\Turn;

final readonly class TurnModel extends DatabaseModel {
    private const string TIMEZONE = 'America/Argentina/Buenos_Aires';

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

    public function generateMonth(): void
    {
        $tz = new \DateTimeZone(self::TIMEZONE);
        $now = new DateTime('now', $tz);

        $firstDay = new DateTime($now->format('Y-m-01 00:00:00'), $tz);
        $lastDay  = (clone $firstDay)->modify('last day of this month')->setTime(23, 59, 59);

        $query = "
            SELECT 
                tc.id as config_id,
                tc.id_barber,
                tcd.day as raw_day,
                TIME(tcd.hour_begin) as hour_begin,
                TIME(tcd.hour_end) as hour_end,
                TIME(tcd.turn_time) as turn_time
            FROM turns_config tc
            JOIN turns_config_day tcd ON tcd.id_turns_config = tc.id
        ";

        $rows = $this->primitiveQuery($query);
        
        $intervalOneDay = new DateInterval('P1D');

        $daysInNumber = $this->daysInNumbers($rows);

        for ($date = clone $firstDay; $date <= $lastDay; $date->add($intervalOneDay)) {
            $weekday = (int)$date->format('N');
            
            if (in_array($weekday,$daysInNumber)) {
                $this->generateDaysTurns($rows[$weekday-2]);
            }
        }
    }

    private function generateDaysTurns(array $day): void
    {
        print_r($day);
    }

    private function daysInNumbers(array $days): array
    {
        $map = [
            'lunes'     => 1,
            'martes'    => 2,
            'miercoles' => 3,
            'jueves'    => 4,
            'viernes'   => 5,
            'sabado'    => 6,
            'domingo'   => 7
        ];

        $resultado = [];

        foreach ($days as $item) {
            $day = is_array($item) && isset($item['raw_day']) ? $item['raw_day'] : $item;

            if (!is_string($day)) continue;

            $d = mb_strtolower(trim($day));
            $d = strtr($d, ['á'=>'a','é'=>'e','í'=>'i','ó'=>'o','ú'=>'u','ü'=>'u','ñ'=>'n']);
            $d = preg_replace('/[^\p{L}\p{N}]+/u', '', $d);

            if (isset($map[$d])) {
                $resultado[] = $map[$d];
            }
        }

        return $resultado;
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