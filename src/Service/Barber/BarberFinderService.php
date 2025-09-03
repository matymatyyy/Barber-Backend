<?php 

declare(strict_types = 1);

namespace Src\Service\Barber;

use Src\Model\Barber\BarberModel;
use Src\Entity\Barber\Barber;
use Src\Entity\Barber\Exception\BarberNotFoundException;

final readonly class BarberFinderService {

    private BarberModel $model;

    public function __construct() 
    {
        $this->model = new BarberModel();
    }

    public function find(int $id): Barber 
    {
        $barber = $this->model->find($id);

        if ($barber === null) {
            throw new BarberNotFoundException();
        }

        return $barber;
    }
}
