<?php 

namespace Src\Entity\Client\Exception;

use Exception;

final class ClientNotFoundException extends Exception {
    public function __construct() {
        parent::__construct("Las credenciales del usuario son invalidas.");
    }
}