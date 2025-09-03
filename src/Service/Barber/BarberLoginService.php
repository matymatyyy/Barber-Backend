<?php 

declare(strict_types = 1);

namespace Src\Service\Barber;

use Src\Model\Barber\BarberModel;
use Src\Entity\Barber\Barber;
use Src\Entity\Barber\Exception\BarberNotFoundException;

final readonly class BarberLoginService {

    private BarberModel $model;
    private BarberTokenGeneratorService $tokenGenerator;

    public function __construct() 
    {
        $this->model = new BarberModel();
        $this->tokenGenerator = new BarberTokenGeneratorService();
    }

    public function login(string $email, string $password): Barber 
    {
        $barber = $this->model->findByEmailAndPassword($email, $password);

        if ($barber === null) {
            throw new BarberNotFoundException();
        }

        $this->tokenGenerator->generate($barber);

        return $barber;
    }

}

