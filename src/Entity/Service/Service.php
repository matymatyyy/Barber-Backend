<?php 

namespace Src\Entity\Service;

final class Service{
    public function __construct(
        private readonly ?int $id,
        private string $type,
        private int $price
    ) {
    }

    public static function create(
        string $type,
        int $price
        ): self
    {
        return new self(null, $type, $price);
    }

    public function modify(
        string $type,
        int $price
    ): void
    {
        $this->type = $type;
        $this->price = $price;
    }

    public function id(): ?int
    {
        return $this->id;
    }

    public function type(): string
    {
        return $this->type;
    }

    public function price(): int
    {
        return $this->price;
    }
}
