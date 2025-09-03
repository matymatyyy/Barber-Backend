<?php 

declare(strict_types = 1);

namespace Src\Service\Barber;

use Src\Model\Barber\BarberModel;
use Src\Entity\Barber\Barber;
use Src\Entity\Barber\Exception\BarberNotAuthorizedException;

final readonly class BarberTokenValidatorService {

    private BarberModel $model;

    public function __construct() 
    {
        $this->model = new BarberModel();
    }

    public function validate(string $token): Barber 
    {
        $barber = $this->model->findByToken($token);

        if ($barber === null) {
            throw new BarberNotAuthorizedException();
        }

        return $barber;
    }

}

