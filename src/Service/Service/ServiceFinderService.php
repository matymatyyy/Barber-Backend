<?php 

declare(strict_types = 1);

namespace Src\Service\Service;

use Src\Model\Service\ServiceModel;
use Src\Entity\Service\Service;
use Src\Entity\Service\Exception\ServiceNotFoundException;

final readonly class ServiceFinderService {

    private ServiceModel $model;

    public function __construct() 
    {
        $this->model = new ServiceModel();
    }

    public function find(int $id): Service 
    {
        $service = $this->model->find($id);

        if ($service === null) {
            throw new ServiceNotFoundException($id);
        }

        return $service;
    }
}
