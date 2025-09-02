<?php

final readonly class TurnRoutes
{
    public static function getRoutes(): array
    {
        return [
            [
                "name" => "turn_get",
                "url" => "/turns",
                "controller" => "Turn/TurnGetController.php",
                "method" => "GET",
                "parameters" => [
                    [
                        "name" => "id",
                        "type" => "int"
                    ]
                ]
            ],
            [
                "name" => "turns_get",
                "url" => "/turns",
                "controller" => "Turn/TurnGetsController.php",
                "method" => "GET"
            ],
            [
                "name" => "turns_create",
                "url" => "/turns",
                "controller" => "Turn/TurnPostController.php",
                "method" => "POST"
            ],
            [
                [
                    "name" => "turn_update",
                    "url" => "/turns",
                    "controller" => "Turn/TurnPutController.php",
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
                "name" => "turn_detele",
                "url" => "/turns",
                "controller" => "Turn/TurnDeleteController.php",
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
