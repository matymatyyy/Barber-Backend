<?php 

declare(strict_types = 1);

namespace Src\Service\Domain;

use Src\Model\Domain\DomainModel;
use Src\Entity\Domain\Domain;
use Src\Entity\Domain\Exception\DomainNotFoundException;

final readonly class DomainFinderService {

    private DomainModel $model;

    public function __construct() 
    {
        $this->model = new DomainModel();
    }

    public function find(int $id): Domain 
    {
        $domain = $this->model->find($id);

        if ($domain === null) {
            throw new DomainNotFoundException($id);
        }

        return $domain;
    }

}

