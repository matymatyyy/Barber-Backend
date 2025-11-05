<?php 

namespace Src\Entity\Payment;

final class Payment {
    
    public function __construct(
        private readonly ?int $id,
        private int $turnId,
        private int $clientId,
        private string $paymentMethod,
        private ?string $paymentId,
        private string $paymentStatus,
        private float $amount
    ) {}

    public static function create(
        int $turnId,
        int $clientId,
        string $paymentMethod,
        float $amount,
        ?string $paymentId = null,
        string $paymentStatus = 'pending'
    ): self {
        return new self(
            null,
            $turnId,
            $clientId,
            $paymentMethod,
            $paymentId,
            $paymentStatus,
            $amount
        );
    }

    public function updateStatus(string $status, ?string $paymentId = null): void {
        $this->paymentStatus = $status;
        if ($paymentId !== null) {
            $this->paymentId = $paymentId;
        }
    }

    public function id(): ?int {
        return $this->id;
    }

    public function turnId(): int {
        return $this->turnId;
    }

    public function clientId(): int {
        return $this->clientId;
    }

    public function paymentMethod(): string {
        return $this->paymentMethod;
    }

    public function paymentId(): ?string {
        return $this->paymentId;
    }

    public function paymentStatus(): string {
        return $this->paymentStatus;
    }

    public function amount(): float {
        return $this->amount;
    }
}
