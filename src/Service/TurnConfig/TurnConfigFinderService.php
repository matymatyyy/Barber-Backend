<?php 

declare(strict_types = 1);

namespace Src\Service\TurnConfig;

use Src\Model\TurnConfig\TurnConfigModel;
use Src\Entity\TurnConfig\TurnConfig;
use Src\Entity\TurnConfig\Exception\TurnConfigNotFoundException;

final readonly class TurnConfigFinderService {

    private TurnConfigModel $model;

    public function __construct() 
    {
        $this->model = new TurnConfigModel();
    }

    public function find(int $id): TurnConfig 
    {
        $turnConfig = $this->model->find($id);

        if ($turnConfig === null) {
            throw new TurnConfigNotFoundException($id);
        }

        return $turnConfig;
    }

}

