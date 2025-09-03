<?php 

final readonly class BarberRoutes {
  public static function getRoutes(): array {
    return [
      [
        "name" => "barber_login",
        "url" => "login",
        "controller" => "Barber/BarberLoginController.php",
        "method" => "POST"
      ],
      [
        "name" => "barber_create",
        "url" => "/barbers",
        "controller" => "Barber/BarberPostController.php",
        "method" => "POST",
      ],
      [
        [
          "name" => "barber_update",
          "url" => "/barbers",
          "controller" => "Barber/BarberPutController.php",
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
        "name" => "barber_detele",
        "url" => "/barbers",
        "controller" => "Barber/BarberDeleteController.php",
        "method" => "DELETE",
        "parameters" => [
          [
            "name" => "id",
            "type" => "int"
          ]
        ]
      ],
      [
        "name" => "barber_get",
        "url" => "/barbers",
        "controller" => "Barber/BarberGetController.php",
        "method" => "GET",
        "parameters" => [
          [
            "name" => "id",
            "type" => "int"
          ]
        ]
      ],
      [
        "name" => "barbers_get",
        "url" => "/barbers",
        "controller" => "Barber/BarbersGetController.php",
        "method" => "GET"
      ],
    ];
  }
}
