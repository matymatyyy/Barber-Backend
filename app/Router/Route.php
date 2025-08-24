<?php 

final readonly class Route {
    public function __construct(
        private string $name,
        private string $url,
        private string $method,
        private string $controller,
        private array $parameters
    ) {}

    public static function fromArray(array $data): Route
    {
        return new Route(
            $data["name"] ?? '',
            $data["url"] ?? '',
            $data["method"] ?? '',
            $data["controller"] ?? '',
            $data["parameters"] ?? []
        );
    }

    public function name(): string
    {
        return $this->name;
    }

    public function url(): string
    {
        return $this->url;
    }

    public function method(): string
    {
        return $this->method;
    }

    public function controller(): string
    {
        return $this->controller;
    }

    public function parameters(): array
    {
        return $this->parameters;
    }

    public function className(): string 
    {
        return basename($this->controller(), ".php");
    }
}