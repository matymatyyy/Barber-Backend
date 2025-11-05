<?php 

declare(strict_types = 1);

namespace Src\Service\MercadoPago;

use MercadoPago\MercadoPagoConfig;
use MercadoPago\Client\Preference\PreferenceClient;
use MercadoPago\Exceptions\MPApiException;
use Src\Model\Payment\PaymentModel;
use Src\Entity\Payment\Payment;

final readonly class MercadoPagoPreferenceService {
    
    private PaymentModel $paymentModel;

    public function __construct() {
        $this->paymentModel = new PaymentModel();
        MercadoPagoConfig::setAccessToken($_ENV['MERCADOPAGO_ACCESS_TOKEN']);
    }

    public function createPreference(
        int $turnId,
        int $clientId,
        string $clientEmail,
        float $amount,
        string $title = 'Reserva de Turno - Barbería',
        ?string $description = null
    ): array {
        try {
            if ($amount <= 0) {
                return [
                    'success' => false,
                    'error' => 'El monto debe ser mayor a 0',
                    'amount_received' => $amount
                ];
            }

            if (empty($clientEmail) || !filter_var($clientEmail, FILTER_VALIDATE_EMAIL)) {
                return [
                    'success' => false,
                    'error' => 'Email inválido',
                    'email_received' => $clientEmail
                ];
            }

            $frontend = $_ENV['FRONTEND_URL'] ?? null;
            if (empty($frontend)) {
                return [
                    'success' => false,
                    'error' => 'FRONTEND_URL no definido en variables de entorno',
                    'hint' => 'Define FRONTEND_URL en tu .env (ej: https://tusitio.com)'
                ];
            }
            $frontend = rtrim($frontend, '/');

            $payment = Payment::create(
                $turnId,
                $clientId,
                'mercadopago',
                $amount,
                null,
                'pending'
            );
            $this->paymentModel->insert($payment);

            $client = new PreferenceClient();

            $backUrls = [
                "success" => $frontend . "/reservation/success",
                "failure" => $frontend . "/reservation/failure",
                "pending" => $frontend . "/reservation/pending"
            ];

            $isLocalFront = preg_match('#^(https?://)?(localhost|127\.0\.0\.1)(:\d+)?#i', $frontend);

            $payload = [
                "items" => [
                    [
                        "title" => $title,
                        "description" => $description ?? "Turno ID: {$turnId}",
                        "quantity" => 1,
                        "unit_price" => $amount,
                        "currency_id" => "ARS"
                    ]
                ],
                "payer" => [
                    "email" => $clientEmail
                ],
                "back_urls" => $backUrls,
                "external_reference" => (string)$turnId,
                "statement_descriptor" => "BARBERIA",
                "notification_url" => ($_ENV['BACKEND_URL'] ?? '') . "/mercadopago/webhook",
                "expires" => true,
                "expiration_date_from" => date('c'),
                "expiration_date_to" => date('c', strtotime('+30 minutes'))
            ];

            // Solo agregar auto_return si NO estamos en localhost
            if (!$isLocalFront) {
                $payload["auto_return"] = "approved";
            }

            $preference = $client->create($payload);

            return [
                'success' => true,
                'id' => $preference->id,
                'init_point' => $preference->init_point,
                'sandbox_init_point' => $preference->sandbox_init_point
            ];

        } catch (MPApiException $e) {
            $apiResponse = $e->getApiResponse();
            $content = $apiResponse->getContent();

            return [
                'success' => false,
                'error' => 'Error al crear preferencia de Mercado Pago',
                'message' => $e->getMessage(),
                'status' => $apiResponse->getStatusCode(),
                'details' => $content,
                'cause' => $content['cause'] ?? null,
                'mp_message' => $content['message'] ?? null
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'error' => 'Error inesperado',
                'message' => $e->getMessage()
            ];
        }
    }
}
