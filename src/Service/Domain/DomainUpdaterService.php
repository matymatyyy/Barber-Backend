<?php 

declare(strict_types = 1);

namespace Src\Service\Domain;

use Src\Model\Domain\DomainModel;

final readonly class DomainUpdaterService {

    private DomainModel $model;
    private DomainFinderService $finder;

    public function __construct() 
    {
        $this->model = new DomainModel();
        $this->finder = new DomainFinderService();
    }

    public function update(
        string $name, 
        string $code,
        int $id
    ): void 
    {
        $domain = $this->finder->find($id);

        $domain->modify($name, $code);

        $this->model->update($domain);
    }

}

