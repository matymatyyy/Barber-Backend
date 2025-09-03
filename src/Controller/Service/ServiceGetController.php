<?php 

use Src\Service\Service\ServiceFinderService;

final readonly class ServiceGetController{
    private ServiceFinderService $service;

    public function __construct() {
        $this->service = new ServiceFinderService();
    }

    public function start(int $id): void 
    {
        $service = $this->service->find($id);
     
        echo json_encode([
            'id' => $service->id(),
            'type' => $service->type(),
            'price' => $service->price()
        ]);
    }
}
