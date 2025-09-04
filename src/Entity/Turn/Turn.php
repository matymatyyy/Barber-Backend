<?php 

namespace Src\Entity\Turn;

use DateTime;

final class Turn{
    public function __construct(
        private readonly ?int $id,
        private ?int $barberId,
        private ?int $clientId,
        private DateTime $date,
        private DateTime $hourBegin,
        private DateTime $hourEnd,
        private ?bool $state
    ) {
    }

    public static function create(
        DateTime $date,
        DateTime $hourBegin,
        DateTime $hourEnd,
        ?bool $state,
        ?int $barberId = null,
        ?int $clientId = null
        ): self
    {
        return new self(null,$barberId,$clientId,$date,$hourBegin,$hourEnd, $state);
    }

    public function modify(
        ?int $barberId,
        ?int $clientId,
        DateTime $date,
        DateTime $hourBegin,
        DateTime $hourEnd,
        ?bool $state
        ): void
    {
        $this->barberId = $barberId;
        $this->clientId = $clientId;
        $this->date = $date;
        $this->hourBegin = $hourBegin;
        $this->hourEnd = $hourEnd;
        $this->state = $state;
    }

    public function id(): ?int
    {
        return $this->id;
    }

    public function barberId(): ?int
    {
        return $this->barberId;
    }

    public function clientId(): ?int
    {
        return $this->clientId;
    }

    public function date(): DateTime
    {
        return $this->date;
    }
    
    public function hourBegin(): DateTime
    {
        return $this->hourBegin;
    }

    public function hourEnd(): DateTime
    {
        return $this->hourEnd;
    }
    public function state(): ?bool
    {
        return $this->state;
    }
}
