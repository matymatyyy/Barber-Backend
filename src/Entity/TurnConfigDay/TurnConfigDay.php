<?php 

namespace Src\Entity\TurnConfigDay;

use DateTime;

final class TurnConfigDay{
    public function __construct(
        private readonly ?int $id,
        private ?int $turnConfigId,
        private string $day,
        private DateTime $hourBegin,
        private DateTime $hourEnd,
        private DateTime $turnTime
    ) {
    }

    public static function create(
        ?int $turnConfigId,
        string $day,
        DateTime $hourBegin,
        DateTime $hourEnd,
        DateTime $turnTime,
        ): self
    {
        return new self(null,
        $turnConfigId,
        $day,
        $hourBegin,
        $hourEnd,
        $turnTime,
        );
    }

    public function modify(
        ?int $turnConfigId,
        string $day,
        DateTime $hourBegin,
        DateTime $hourEnd,
        DateTime $turnTime
        ): void
    {
        $this->turnConfigId = $turnConfigId;
        $this->day = $day;
        $this->hourBegin = $hourBegin;
        $this->hourEnd = $hourEnd;
        $this->turnTime = $turnTime;
    }

    public function id(): ?int
    {
        return $this->id;
    }

    public function turnConfigId(): ?int
    {
        return $this->turnConfigId;
    }

    public function day(): string
    {
        return $this->day;
    }

    public function turnTime(): DateTime
    {
        return $this->turnTime;
    }
    
    public function hourBegin(): DateTime
    {
        return $this->hourBegin;
    }

    public function hourEnd(): DateTime
    {
        return $this->hourEnd;
    }
}
