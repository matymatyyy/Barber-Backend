<?php 

namespace Src\Entity\TurnConfig;

use DateTime;

final class TurnConfig{
    public function __construct(
        private readonly ?int $id,
        private readonly ?int $barberId  
    ) {
    }

    public static function create(
        ?int $barberId = null
        ): self
    {
        return new self(null,$barberId);
    }

    public function modify(
        ?int $barberId,
        ): void
    {
        $this->barberId = $barberId;
    }

    public function id(): ?int
    {
        return $this->id;
    }

    public function barberId(): ?int
    {
        return $this->barberId;
    }

}
