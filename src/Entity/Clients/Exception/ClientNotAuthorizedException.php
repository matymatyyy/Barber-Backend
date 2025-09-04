<?php 

namespace Src\Entity\Client\Exception;

use Exception;

final class ClientNotAuthorizedException extends Exception {
    public function __construct() {
        parent::__construct("El usuario no se encuentra autorizado.");
    }
}