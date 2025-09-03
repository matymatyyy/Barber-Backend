<?php 

use Src\Middleware\BarberAuthMiddleware;
use Src\Service\Barber\BarberFinderService;

final readonly class BarberGetController extends BarberAuthMiddleware {
    private BarberFinderService $service;

    public function __construct() {
        parent::__construct();
        $this->service = new BarberFinderService();
    }

    public function start(int $id): void 
    {
        $barber = $this->service->find($id);
     
        echo json_encode([
            'id' => $barber->id(),
            'name' => $barber->name(),
            'email' => $barber->email(),
            'password' => $barber->password(),
            'dni' => $barber->dni(),
            'cellphone' => $barber->cellphone()
        ]);
    }
}
