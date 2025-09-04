<?php

final readonly class TurnConfigRoutes
{
    public static function getRoutes(): array
    {
        return [
            [
                "name" => "turn_config_get",
                "url" => "/turns_config",
                "controller" => "TurnConfig/TurnConfigGetController.php",
                "method" => "GET",
                "parameters" => [
                    [
                        "name" => "id",
                        "type" => "int"
                    ]
                ]
            ],
            [
                "name" => "turns_config_get",
                "url" => "/turns_config",
                "controller" => "TurnConfig/TurnsConfigGetController.php",
                "method" => "GET"
            ],
            [
                "name" => "turns_config_create",
                "url" => "/turns_config",
                "controller" => "TurnConfig/TurnConfigPostController.php",
                "method" => "POST"
            ],
            [
                [
                    "name" => "turn_config_update",
                    "url" => "/turns_config",
                    "controller" => "TurnConfig/TurnConfigPutController.php",
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
                "name" => "turn_config_detele",
                "url" => "/turns_config",
                "controller" => "TurnConfig/TurnConfigDeleteController.php",
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
