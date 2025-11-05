<?php 

namespace Src\Model\Payment;

use Src\Model\DatabaseModel;
use Src\Entity\Payment\Payment;

final readonly class PaymentModel extends DatabaseModel {

    public function insert(Payment $payment): void {
        $query = <<<INSERT_QUERY
            INSERT INTO payment_history
            (turn_id, client_id, payment_method, payment_id, payment_status, amount)
            VALUES
            (:turnId, :clientId, :paymentMethod, :paymentId, :paymentStatus, :amount)
        INSERT_QUERY;

        $parameters = [
            'turnId' => $payment->turnId(),
            'clientId' => $payment->clientId(),
            'paymentMethod' => $payment->paymentMethod(),
            'paymentId' => $payment->paymentId(),
            'paymentStatus' => $payment->paymentStatus(),
            'amount' => $payment->amount()
        ];

        $this->primitiveQuery($query, $parameters);
    }

    public function updateStatus(int $turnId, string $status, ?string $paymentId = null): void {
        $query = <<<UPDATE_QUERY
            UPDATE payment_history
            SET 
                payment_status = :status,
                payment_id = COALESCE(:paymentId, payment_id)
            WHERE
                turn_id = :turnId
            ORDER BY id DESC
            LIMIT 1
        UPDATE_QUERY;

        $parameters = [
            'status' => $status,
            'paymentId' => $paymentId,
            'turnId' => $turnId
        ];

        $this->primitiveQuery($query, $parameters);
    }

    public function findByPaymentId(string $paymentId): ?Payment {
        $query = <<<SELECT_QUERY
            SELECT
                id,
                turn_id,
                client_id,
                payment_method,
                payment_id,
                payment_status,
                amount
            FROM
                payment_history
            WHERE
                payment_id = :paymentId
            ORDER BY id DESC
            LIMIT 1
        SELECT_QUERY;

        $parameters = ['paymentId' => $paymentId];
        $result = $this->primitiveQuery($query, $parameters);

        return $this->toPayment($result[0] ?? null);
    }

    public function findByTurnId(int $turnId): ?Payment {
        $query = <<<SELECT_QUERY
            SELECT
                id,
                turn_id,
                client_id,
                payment_method,
                payment_id,
                payment_status,
                amount
            FROM
                payment_history
            WHERE
                turn_id = :turnId
            ORDER BY id DESC
            LIMIT 1
        SELECT_QUERY;

        $parameters = ['turnId' => $turnId];
        $result = $this->primitiveQuery($query, $parameters);

        return $this->toPayment($result[0] ?? null);
    }

    private function toPayment(?array $primitive): ?Payment {
        if ($primitive === null) {
            return null;
        }

        return new Payment(
            $primitive['id'],
            $primitive['turn_id'],
            $primitive['client_id'],
            $primitive['payment_method'],
            $primitive['payment_id'],
            $primitive['payment_status'],
            (float)$primitive['amount']
        );
    }
}
