<?php 

declare(strict_types = 1);

namespace Src\Service\Service;

use Src\Model\Service\ServiceModel;

final readonly class ServiceDeleterService {

    private ServiceModel $model;
    private ServiceFinderService $finder;

    public function __construct() 
    {
        $this->model = new ServiceModel();
        $this->finder = new ServiceFinderService();
    }

    public function delete(
        int $id
    ): void 
    {
        $service = $this->finder->find($id);

        $this->model->delete($service->id());
    }
}

