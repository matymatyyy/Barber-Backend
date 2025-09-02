<?php 

namespace Src\Entity\TurnConfig\Exception;

use Exception;

final class TurnConfigNotFoundException extends Exception {
    public function __construct(int $id) {
        parent::__construct("No se encontro el turno correspondiente. Id: ".$id);
    }
}