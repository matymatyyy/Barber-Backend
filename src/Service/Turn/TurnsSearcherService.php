<?php 

namespace Src\Service\Turn;

use Src\Entity\Turn\Turn;
use Src\Model\Turn\TurnModel;

final readonly class TurnsSearcherService
{
    private TurnModel $turnModel;

    public function __construct() {
        $this->turnModel = new TurnModel();
    }

    /** @return Turn[] */
    public function search(): array
    {
        return $this->turnModel->search();
    }
}