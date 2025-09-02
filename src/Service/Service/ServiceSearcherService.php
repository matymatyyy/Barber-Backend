<?php 

namespace Src\Service\Service;

use Src\Entity\Service\Service;
use Src\Model\Service\ServiceModel;

final readonly class ServicesSearcherService {
    private ServiceModel $serviceModel;

    public function __construct() {
        $this->serviceModel = new ServiceModel();
    }

    /** @return Service[] */
    public function search(): array
    {
        return $this->serviceModel->search();
    }
}