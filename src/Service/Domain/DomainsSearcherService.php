<?php 

namespace Src\Service\Domain;

use Src\Entity\Domain\Domain;
use Src\Model\Domain\DomainModel;

final readonly class DomainsSearcherService {
    private DomainModel $domainModel;

    public function __construct() {
        $this->domainModel = new DomainModel();
    }

    /** @return Domain[] */
    public function search(): array
    {
        return $this->domainModel->search();
    }
}