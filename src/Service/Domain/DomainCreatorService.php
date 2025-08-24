<?php 

declare(strict_types = 1);

namespace Src\Service\Domain;

use Src\Model\Domain\DomainModel;
use Src\Entity\Domain\Domain;

final readonly class DomainCreatorService {

    private DomainModel $model;

    public function __construct() 
    {
        $this->model = new DomainModel();
    }

    public function create(string $name, string $code): void 
    {
        $domain = Domain::create($name, $code);
        $this->model->insert($domain);
    }

}

