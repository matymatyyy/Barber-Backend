<?php 

namespace Src\Entity\Service\Exception;

use Exception;

final class ServiceNotFoundException extends Exception {
    public function __construct(int $id) {
        parent::__construct("No se encontro el servicio correspondiente. Id: ".$id);
    }
}
