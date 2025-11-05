<?php 

use Src\Utils\ControllerUtils;
use Src\Service\MercadoPago\MercadoPagoPreferenceService;

final readonly class MercadoPagoPreferenceController {
    private MercadoPagoPreferenceService $service;

    public function __construct() {
        $this->service = new MercadoPagoPreferenceService();
    }

    public function start(): void {
        header('Content-Type: application/json');

        $turnId = ControllerUtils::getPost('turnId');
        $clientId = ControllerUtils::getPost('clientId');
        $clientEmail = ControllerUtils::getPost('clientEmail');
        $amount = ControllerUtils::getPost('amount', false, 5000);
        $title = ControllerUtils::getPost('title', false, 'Reserva de Turno - Barbería');
        $description = ControllerUtils::getPost('description', false, null);

        $result = $this->service->createPreference(
            (int)$turnId,
            (int)$clientId,
            $clientEmail,
            (float)$amount,
            $title,
            $description
        );

        if (!$result['success']) {
            http_response_code(500);
        }

        echo json_encode($result);
    }
}
