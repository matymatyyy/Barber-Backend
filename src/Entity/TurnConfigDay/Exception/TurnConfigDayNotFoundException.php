<?php 

namespace Src\Entity\TurnConfigDay\Exception;

use Exception;

final class TurnConfigDayNotFoundException extends Exception {
    public function __construct(int $id) {
        parent::__construct("No se encontro el turno correspondiente. Id: ".$id);
    }
}