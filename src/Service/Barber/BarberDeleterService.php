<?php 

declare(strict_types = 1);

namespace Src\Service\Barber;

use Src\Model\Barber\BarberModel;

final readonly class BarberDeleterService {

    private BarberModel $model;
    private BarberFinderService $finder;

    public function __construct() 
    {
        $this->model = new BarberModel();
        $this->finder = new BarberFinderService();
    }

    public function delete(
        int $id
    ): void 
    {
        $barber = $this->finder->find($id);

        $this->model->delete($barber->id());
    }
}

