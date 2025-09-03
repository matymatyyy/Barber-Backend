<?php 

namespace Src\Entity\Barber\Exception;

use Exception;

final class BarberNotFoundException extends Exception {
    public function __construct() {
        parent::__construct("Las credenciales del barbero son invalidas.");
    }
}