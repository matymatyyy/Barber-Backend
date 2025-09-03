<?php 

declare(strict_types = 1);

namespace Src\Service\Barber;

use Src\Model\Barber\BarberModel;
use Src\Entity\Barber\Barber;

final readonly class BarberCreatorService {

    private BarberModel $model;

    public function __construct() 
    {
        $this->model = new BarberModel();
    }

    public function create(
        string $name, 
        string $email, 
        string $password,
        int $dni,
        string $cellphone): void 
    {
        $barber = Barber::create(
        $name, 
        $email, 
        $password,
        $dni,
        $cellphone);

        $this->model->insert($barber);
    }
}

