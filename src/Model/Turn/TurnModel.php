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
            'date' => $turn->date()->format('Y-m-d'),
            'hourBegin' => $turn->hourBegin()->format('H:i:s'),
            'hourEnd' => $turn->hourEnd()->format('H:i:s'),
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
            'date' => $turn->date()->format('Y-m-d'),
            'hourBegin' => $turn->hourBegin()->format('H:i:s'),
            'hourEnd' => $turn->hourEnd()->format('H:i:s'),
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
            ORDER BY 
                CASE tcd.day 
                    WHEN 'Lunes' THEN 1
                    WHEN 'Martes' THEN 2 
                    WHEN 'Miercoles' THEN 3
                    WHEN 'Jueves' THEN 4
                    WHEN 'Viernes' THEN 5
                    WHEN 'Sabado' THEN 6
                    WHEN 'Domingo' THEN 7
                END
        ";

        $configRows = $this->primitiveQuery($query);

        $dayConfigs = [];
        foreach ($configRows as $config) {
            $dayNumber = $this->dayNameToNumber($config['raw_day']);
            if ($dayNumber !== null) {
                $dayConfigs[$dayNumber] = $config;
            }
        }
        
        $intervalOneDay = new DateInterval('P1D');

        for ($date = clone $firstDay; $date <= $lastDay; $date->add($intervalOneDay)) {
            $weekday = (int)$date->format('N');
            
            if (isset($dayConfigs[$weekday])) {
                if (!$this->turnsExistForDate($date, $dayConfigs[$weekday]['id_barber'])) {
                    $this->generateDaysTurns($dayConfigs[$weekday], $date);
                }
            }
        }
    }

    private function turnsExistForDate(DateTime $date, int $barberId): bool
    {
        $query = "SELECT COUNT(*) as count FROM turns WHERE date = :date AND id_barber = :barberId";
        $result = $this->primitiveQuery($query, [
            'date' => $date->format('Y-m-d'),
            'barberId' => $barberId
        ]);
        
        return ($result[0]['count'] ?? 0) > 0;
    }

    private function generateDaysTurns(array $day, DateTime $date): void 
    {
        $barberId = (int)$day['id_barber'];
        $hourBegin = new DateTime($day['hour_begin']);
        $hourEnd   = new DateTime($day['hour_end']);
        
        $parts = explode(':', $day['turn_time']);
        $turnInterval = new DateInterval("PT{$parts[0]}H{$parts[1]}M{$parts[2]}S");

        for ($timeInit = clone $hourBegin; $timeInit < $hourEnd; $timeInit->add($turnInterval)) {
            $startTime = clone $timeInit;
            $endTime = (clone $startTime)->add($turnInterval);
            
            if ($endTime > $hourEnd) {
                break;
            }

            $turn = Turn::create(
                $date,
                $startTime,
                $endTime,
                null,
                $barberId
            );

            $this->insert($turn);
        }
    }

    private function dayNameToNumber(string $dayName): ?int
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

        $normalized = mb_strtolower(trim($dayName));
        $normalized = strtr($normalized, ['á'=>'a','é'=>'e','í'=>'i','ó'=>'o','ú'=>'u','ü'=>'u','ñ'=>'n']);
        $normalized = preg_replace('/[^\p{L}\p{N}]+/u', '', $normalized);

        return $map[$normalized] ?? null;
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