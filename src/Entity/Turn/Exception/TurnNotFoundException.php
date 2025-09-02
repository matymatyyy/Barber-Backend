<?php 

namespace Src\Entity\Turn\Exception;

use Exception;

final class TurnNotFoundException extends Exception {
    public function __construct(int $id) {
        parent::__construct("No se encontro el turno correspondiente. Id: ".$id);
    }
}