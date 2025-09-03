<?php 

declare(strict_types = 1);

namespace Src\Service\Barber;

use Src\Model\Barber\BarberModel;
use Src\Entity\Barber\Barber;

final readonly class BarberTokenGeneratorService {

    private BarberModel $model;

    public function __construct() 
    {
        $this->model = new BarberModel();
    }

    public function generate(Barber $barber): Barber 
    {
        $barber->generateToken();
        $this->model->updateToken($barber);
        return $barber;
    }

}

