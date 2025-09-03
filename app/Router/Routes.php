<?php 

include_once "Route.php";
include_once "Router.php";

function startRouter(): Router 
{
    $routes = [];

    include_once "Routes/DomainRoutes.php";
    $routes = array_merge($routes, DomainRoutes::getRoutes());

    include_once "Routes/ClientRoutes.php";
    $routes = array_merge($routes, ClientRoutes::getRoutes());

    include_once "Routes/FileRoutes.php";
    $routes = array_merge($routes, FileRoutes::getRoutes());

    include_once "Routes/ServiceRoutes.php";
    $routes = array_merge($routes, ServiceRoutes::getRoutes());

    include_once "Routes/TurnRoutes.php";
    $routes = array_merge($routes, TurnRoutes::getRoutes());

    include_once "Routes/TurnConfigRoutes.php";
    $routes = array_merge($routes, TurnConfigRoutes::getRoutes());
    
    include_once "Routes/TurnConfigDayRoutes.php";
    $routes = array_merge($routes, TurnConfigDayRoutes::getRoutes());

    include_once "Routes/BarberRoutes.php";
    $routes = array_merge($routes, BarberRoutes::getRoutes());

    $routesClass = [];
    foreach ($routes as $route) {
        $routesClass[] = Route::fromArray($route);
    }

    return new Router($routesClass);
}