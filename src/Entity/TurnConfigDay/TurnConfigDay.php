<?php 

namespace Src\Entity\TurnConfigDay;

use DateTime;

final class TurnConfigDay{
    public function __construct(
        private readonly ?int $id,
        private readonly ?int $turnConfigId,
        private readonly string $day,
        private DateTime $turnTime,
        private DateTime $hourBegin,
        private DateTime $hourEnd
    ) {
    }

    public static function create(
        ?int $turnConfigId,
        string $day,
        DateTime $turnTime,
        DateTime $hourBegin,
        DateTime $hourEnd,
        ): self
    {
        return new self(null,
        $turnConfigId,
        $day,
        $turnTime,
        $hourBegin,
        $hourEnd,
        );
    }

    public function modify(
        ?int $turnConfigId,
        string $day,
        DateTime $turnTime,
        DateTime $hourBegin,
        DateTime $hourEnd
        ): void
    {
        $this->turnConfigId = $turnConfigId;
        $this->day = $day;
        $this->turnTimne = $turnTime;
        $this->hourBegin = $hourBegin;
        $this->hourEnd = $hourEnd;
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
