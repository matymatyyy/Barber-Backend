<?php

final readonly class ServiceRoutes
{
    public static function getRoutes(): array
    {
        return [
            [
                "name" => "services_get",
                "url" => "/services",
                "controller" => "Service/ServicesGetController.php",
                "method" => "GET",
                "parameters" => [
                    [
                        "name" => "id",
                        "type" => "int"
                    ]
                ]
            ],
            [
                "name" => "service_get",
                "url" => "/services",
                "controller" => "Service/ServiceGetController.php",
                "method" => "GET"
            ],
            [
                "name" => "services_create",
                "url" => "/services",
                "controller" => "Service/ServicePostController.php",
                "method" => "POST"
            ],
            [
                [
                    "name" => "service_update",
                    "url" => "/services",
                    "controller" => "Service/ServicePutController.php",
                    "method" => "PUT",
                    "parameters" => [
                        [
                            "name" => "id",
                            "type" => "int"
                        ]
                    ]
                ]
            ],
            [
                "name" => "service_detele",
                "url" => "/services",
                "controller" => "Service/ServiceDeleteController.php",
                "method" => "DELETE",
                "parameters" => [
                    [
                        "name" => "id",
                        "type" => "int"
                    ]
                ]
            ]
        ];
    }
}
