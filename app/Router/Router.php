<?php 

include_once "Route.php";

final readonly class Router {

    /** @param Route[] $routes */
    public function __construct(
        private array $routes
    ) {     
    }

    public function resolve(string $url, string $method): void
    {
        //Buscamos si la ruta me coincide
        $route = $this->filterRoutes($url, $method);
        
        if (empty($route)) {
            throw new Exception("Ruta no encontrada");
        }

        require_once $_SERVER["DOCUMENT_ROOT"]."/src/Controller/".$route->controller();
        
        $parameters = $this->getParameters($route, $url);

        $controller = new ($route->className())();
        $controller->start(...$parameters);
    }

    private function filterRoutes(string $url, string $method): ?Route
    {
        foreach ($this->routes as $route) {

            $urlParameters = $this->getParameters($route, $url);

            if (
                str_contains($url, $route->url()) &&
                $method === $route->method() && 
                $this->validateParameters($urlParameters, $route->parameters())
            ) {
                return $route;
            } 
        }

        return null;
    }

    private function getParameters(Route $route, string $url): array
    {
        $paramString = str_replace($route->url(), '', $url);

        $paramArray = explode("/", trim($paramString, '/'));

        if (sizeof($paramArray) === 1 && empty($paramArray[0])) {
            return [];
        }

        return $paramArray;
    }

    private function validateParameters(array $urlParameters, array $routeParameters): bool
    {
        if (
            sizeof($urlParameters) !== sizeof($routeParameters)
        ) {
            return false;
        }

        $validParameters = 0;
        for ($i = 0; $i < sizeof($routeParameters); $i++) {
            $type = $routeParameters[$i]['type'] ?? 'string';

            if (
                $type === "int" &&
                (int) $urlParameters[$i] === 0
            ) {
                continue;
            }

            $validParameters++;
        }

        if (
            sizeof($urlParameters) !== $validParameters
        ) {
            return false;
        }

        return true;
    }
}