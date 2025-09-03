<?php 

declare(strict_types = 1);

namespace Src\Service\TurnConfig;

use Src\Model\TurnConfig\TurnConfigModel;
use Src\Entity\TurnConfig\TurnConfig;

final readonly class TurnConfigCreatorService {

    private TurnConfigModel $model;

    public function __construct() 
    {
        $this->model = new TurnConfigModel();
    }

    public function create(
        ?int $barberId = null,
        ): void 
    {
        $TurnConfig = TurnConfig::create(
       $barberId);   
        $this->model->insert($TurnConfig);
    }
}

