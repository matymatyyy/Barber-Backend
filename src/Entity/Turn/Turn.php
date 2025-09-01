<?php 

namespace Src\Entity\Turn;

use DateTime;

final class Turn{
    public function __construct(
        private readonly ?int $id,
        private readonly ?int $barberId,
        private readonly ?int $clientId,
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
        ?bool $state
        ): self
    {
        return new self(null,null,null,$date,$hourBegin,$hourEnd, $state);
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
