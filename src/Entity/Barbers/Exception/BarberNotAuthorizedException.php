<?php 

namespace Src\Entity\Barber\Exception;

use Exception;

final class BarberNotAuthorizedException extends Exception {
    public function __construct() {
        parent::__construct("El barbero no se encuentra autorizado.");
    }
}