<?php 

declare(strict_types = 1);

namespace Src\Service\Service;

use Src\Model\Service\ServiceModel;
use Src\Entity\Service\Service;

final readonly class ServiceCreatorService {

    private ServiceModel $model;

    public function __construct() 
    {
        $this->model = new ServiceModel();
    }

    public function create(string $type, int $price): void 
    {
        $Service = Service::create($type, $price);
        $this->model->insert($Service);
    }
}

