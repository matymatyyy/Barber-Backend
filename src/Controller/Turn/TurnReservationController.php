<?php

use Src\Utils\ControllerUtils;
use Src\Service\Turn\TurnReservationService;
use Src\Model\Payment\PaymentModel;
use Src\Entity\Payment\Payment;

readonly class TurnReservationController {
    private TurnReservationService $service;
    private PaymentModel $paymentModel;

    public function __construct() {
        $this->service = new TurnReservationService();
        $this->paymentModel = new PaymentModel();
    }

    public function start(): void {
        header('Content-Type: application/json');

        $id = ControllerUtils::getPost("id");
        $idClient = ControllerUtils::getPost("id_client");
        $paymentMethod = ControllerUtils::getPost("paymentMethod", false, "cash");
        $paymentId = ControllerUtils::getPost("paymentId", false, null);

        if ($paymentMethod === 'cash') {
            $this->service->reservation($id, $idClient);
            
            $payment = Payment::create(
                $id,
                $idClient,
                'cash',
                0,
                null,
                'pending'
            );
            $this->paymentModel->insert($payment);

            echo json_encode([
                'success' => true,
                'message' => 'Reserva confirmada. Pagarás en efectivo en el local.'
            ]);
            return;
        }

        if ($paymentMethod === 'mercadopago' && $paymentId) {
            $payment = $this->paymentModel->findByPaymentId($paymentId);
            
            if ($payment && $payment->paymentStatus() === 'approved') {
                $this->service->reservation($id, $idClient);
                
                echo json_encode([
                    'success' => true,
                    'message' => 'Reserva confirmada con pago de Mercado Pago'
                ]);
                return;
            }
        }

        http_response_code(400);
        echo json_encode([
            'success' => false,
            'error' => 'Método de pago inválido o pago no confirmado'
        ]);
    }
}