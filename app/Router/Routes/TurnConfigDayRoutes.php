<?php

final readonly class TurnConfigDayRoutes
{
    public static function getRoutes(): array
    {
        return [
            [
                "name" => "turn_config_day_get",
                "url" => "/turns_config_day",
                "controller" => "TurnConfigDay/TurnConfigDayGetController.php",
                "method" => "GET",
                "parameters" => [
                    [
                        "name" => "id",
                        "type" => "int"
                    ]
                ]
            ],
            [
                "name" => "turns_config_day_get",
                "url" => "/turns_config_day",
                "controller" => "TurnConfigDay/TurnsConfigDayGetController.php",
                "method" => "GET"
            ],
            [
                "name" => "turns_config_day_create",
                "url" => "/turns_config_day",
                "controller" => "TurnConfigDay/TurnConfigDayPostController.php",
                "method" => "POST"
            ],
            [
                [
                    "name" => "turn_config_day_update",
                    "url" => "/turns_config_day",
                    "controller" => "TurnConfigDay/TurnConfigDayPutController.php",
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
                "name" => "turn_config_day_detele",
                "url" => "/turns_config_day",
                "controller" => "TurnConfigDay/TurnConfigDayDeleteController.php",
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
