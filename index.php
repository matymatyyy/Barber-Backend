<?php

// Validacion para externos
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

// Cargamos configuración de composer
require_once dirname(__DIR__).'/html/vendor/autoload.php';
// Inicializamos el routeador
require_once dirname(__DIR__).'/html/app/Router/Routes.php';
// Inicializamos el autoloader
require_once dirname(__DIR__).'/html/app/Autoloader/Autoloader.php';

// Utilizamos la libreria 'Dotenv' para cargar nuestros datos
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load(); 

// Cargamos el autoloader
spl_autoload_register(
    function ($class): void {
        Autoloader::register($class, [
            "src/Service",
            "src/Infrastructure",
            "src/Model",
            "src/Entity",
            "src/Utils",
            "src/Middleware",
        ]);
    }
);

@session_start();

// Cargamos el routeador
$router = startRouter();

// Obtenemos el URL de donde esta entrando el usuario
$url = $_SERVER["REQUEST_URI"];

$url = explode("?", $url)[0];

try {
    // A partir del URL y del metodo, el Routeador decide por que ruta entrar
    $router->resolve(
        $url,
        $_SERVER['REQUEST_METHOD']
    );
} catch (Exception $e) {   
    if ($e->getMessage() == "El usuario no se encuentra autorizado.") {
        header("HTTP/1.0 401 Not Found");
        $status = 401;
    } else {
        header("HTTP/1.0 404 Not Found");
        $status = 404;        
    }

    echo json_encode([
        "status" => $status,
        "message"=> $e->getMessage()
    ]);
}
