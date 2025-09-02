<?php 

declare(strict_types = 1);

namespace Src\Service\Turn;

use Src\Model\Turn\TurnModel;

final readonly class TurnDeleterService {

    private TurnModel $model;
    private TurnFinderService $finder;

    public function __construct() 
    {
        $this->model = new TurnModel();
        $this->finder = new TurnFinderService();
    }

    public function delete(
        int $id
    ): void 
    {
        $turn = $this->finder->find($id);

        $this->model->delete($turn->id());
    }
}

