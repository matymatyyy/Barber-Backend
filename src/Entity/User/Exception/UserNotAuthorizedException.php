<?php 

namespace Src\Entity\User\Exception;

use Exception;

final class UserNotAuthorizedException extends Exception {
    public function __construct() {
        parent::__construct("El usuario no se encuentra autorizado.");
    }
}