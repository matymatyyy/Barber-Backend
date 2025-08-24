<?php 

namespace Src\Entity\User\Exception;

use Exception;

final class UserNotFoundException extends Exception {
    public function __construct() {
        parent::__construct("Las credenciales del usuario son invalidas.");
    }
}