<?php 

declare(strict_types = 1);

namespace Src\Service\Barber;

use Src\Model\Barber\BarberModel;

final readonly class BarberUpdaterService {

    private BarberModel $model;
    private BarberFinderService $finder;

    public function __construct() 
    {
        $this->model = new BarberModel();
        $this->finder = new BarberFinderService();
    }

    public function update(
        string $name, 
        string $email,
        string $password,
        int $dni, 
        string $cellphone,
        int $id
    ): void 
    {
        $barber = $this->finder->find($id);

        $barber->modify(
            $name,
            $email, 
            $password, 
            $dni, 
            $cellphone, 
            );

        $this->model->update($barber);
    }

}

