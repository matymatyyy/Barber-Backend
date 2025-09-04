<?php 

declare(strict_types = 1);

namespace Src\Service\Service;

use Src\Model\Service\ServiceModel;

final readonly class ServiceUpdateService
{

    private ServiceModel $model;
    private ServiceFinderService $finder;

    public function __construct() 
    {
        $this->model = new ServiceModel();
        $this->finder = new ServiceFinderService();
    }

    public function update(
        string $type, 
        int $price,
        int $id
    ): void 
    {
        $service = $this->finder->find($id);

        $service->modify($type, $price);

        $this->model->update($service);
    }
}
