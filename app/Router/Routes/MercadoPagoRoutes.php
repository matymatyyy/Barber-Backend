<?php 

final readonly class MercadoPagoRoutes {
    public static function getRoutes(): array {
        return [
            [
                "name" => "mercadopago_create_preference",
                "url" => "/mercadopago/create-preference",
                "controller" => "MercadoPago/MercadoPagoPreferenceController.php",
                "method" => "POST"
            ],
            [
                "name" => "mercadopago_webhook",
                "url" => "/mercadopago/webhook",
                "controller" => "MercadoPago/MercadoPagoWebhookController.php",
                "method" => "POST"
            ]
        ];
    }
}
