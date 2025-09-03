<?php 

declare(strict_types = 1);

namespace Src\Service\TurnConfigDay;

use Src\Model\TurnConfigDay\TurnConfigDayModel;
use Src\Entity\TurnConfigDay\TurnConfigDay;
use Src\Entity\TurnConfigDay\Exception\TurnConfigDayNotFoundException;

final readonly class TurnConfigDayFinderService {

    private TurnConfigDayModel $model;

    public function __construct() 
    {
        $this->model = new TurnConfigDayModel();
    }

    public function find(int $id): TurnConfigDay 
    {
        $turnConfigDay = $this->model->find($id);

        if ($turnConfigDay === null) {
            throw new TurnConfigDayNotFoundException($id);
        }

        return $turnConfigDay;
    }

}

