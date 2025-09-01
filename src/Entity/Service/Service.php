<?php 

namespace Src\Entity\Service;

final class Service{
    public function __construct(
        private readonly ?int $id,
        private string $state,
        private int $price
    ) {
    }

    public static function create(
        string $state,
        int $price
        ): self
    {
        return new self(null, $state, $price);
    } 

    public function id(): ?int
    {
        return $this->id;
    }

    public function state(): string
    {
        return $this->state;
    }

    public function price(): int
    {
        return $this->price;
    }
}
