<?php 

declare(strict_types = 1);

namespace Src\Service\MercadoPago;

use MercadoPago\MercadoPagoConfig;
use MercadoPago\Client\Payment\PaymentClient;
use Src\Service\Turn\TurnReservationService;
use Src\Model\Payment\PaymentModel;

final readonly class MercadoPagoWebhookService {
    
    private PaymentModel $paymentModel;
    private TurnReservationService $reservationService;

    public function __construct() {
        $this->paymentModel = new PaymentModel();
        $this->reservationService = new TurnReservationService();
        MercadoPagoConfig::setAccessToken($_ENV['MERCADOPAGO_ACCESS_TOKEN']);
    }

    public function handleWebhook(array $data): array {
        try {
            // Log para debugging
            $this->log('Webhook recibido: ' . json_encode($data));

            $type = $data['type'] ?? null;

            if ($type === 'payment') {
                $paymentId = $data['data']['id'] ?? null;

                if (!$paymentId) {
                    return [
                        'success' => false,
                        'error' => 'Payment ID no encontrado'
                    ];
                }

                return $this->processPayment($paymentId);
            }

            return [
                'success' => true,
                'message' => 'Tipo de notificación no procesado: ' . $type
            ];

        } catch (\Exception $e) {
            $this->log('Error en webhook: ' . $e->getMessage());
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }

    private function processPayment(string $paymentId): array {
        try {
            $client = new PaymentClient();
            $payment = $client->get((int) $paymentId);

            $turnId = (int)$payment->external_reference;
            $status = $payment->status;
            $payerId = $payment->payer->id ?? null;

            $this->log("Pago {$paymentId} - Estado: {$status} - Turno: {$turnId}");

            $this->paymentModel->updateStatus($turnId, $status, $paymentId);

            if ($status === 'approved') {
                $paymentRecord = $this->paymentModel->findByPaymentId($paymentId);
                
                if ($paymentRecord) {
                    $this->reservationService->reservation(
                        $turnId,
                        $paymentRecord->clientId()
                    );

                    $this->log("Turno {$turnId} confirmado - Pago aprobado");
                    
                    return [
                        'success' => true,
                        'message' => 'Pago procesado y reserva confirmada',
                        'turnId' => $turnId,
                        'status' => $status
                    ];
                }
            }

            return [
                'success' => true,
                'message' => 'Pago procesado',
                'status' => $status
            ];

        } catch (\Exception $e) {
            $this->log('Error al procesar pago: ' . $e->getMessage());
            throw $e;
        }
    }

    private function log(string $message): void {
        $logDir = $_SERVER['DOCUMENT_ROOT'] . '/../logs';
        if (!file_exists($logDir)) {
            mkdir($logDir, 0777, true);
        }
        
        $logFile = $logDir . '/mercadopago_webhook.log';
        $timestamp = date('Y-m-d H:i:s');
        file_put_contents($logFile, "[{$timestamp}] {$message}\n", FILE_APPEND);
    }
}
