<?php 

declare(strict_types = 1);

namespace Src\Service\Turn;

use Src\Model\Turn\TurnModel;

final readonly class TurnGenerateMonthService{

    private TurnModel $model;

    public function __construct() 
    {
        $this->model = new TurnModel();
    }

    public function generate(){
        $this->model->generateMonth();
    }
}

