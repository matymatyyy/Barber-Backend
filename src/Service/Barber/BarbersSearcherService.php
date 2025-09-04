<?php 

namespace Src\Service\Barber;

use Src\Entity\Barber\Barber;
use Src\Model\Barber\BarberModel;

final readonly class BarbersSearcherService {
    private BarberModel $barberModel;

    public function __construct() {
        $this->barberModel = new BarberModel();
    }

    /** @return Barber[] */
    public function search(): array
    {
        return $this->barberModel->search();
    }
}