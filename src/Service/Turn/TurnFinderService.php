<?php 

declare(strict_types = 1);

namespace Src\Service\Turn;

use Src\Model\Turn\TurnModel;
use Src\Entity\Turn\Turn;
use Src\Entity\Turn\Exception\TurnNotFoundException;

final readonly class TurnFinderService
{
    private TurnModel $model;

    public function __construct() 
    {
        $this->model = new TurnModel();
    }

    public function find(int $id): Turn 
    {
        $turn = $this->model->find($id);

        if ($turn === null) {
            throw new TurnNotFoundException($id);
        }

        return $turn;
    }
}
