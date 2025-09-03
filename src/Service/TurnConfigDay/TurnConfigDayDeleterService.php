<?php 

declare(strict_types = 1);

namespace Src\Service\TurnConfigDay;

use Src\Model\TurnConfigDay\TurnConfigDayModel;

final readonly class TurnConfigDayDeleterService {

    private TurnConfigDayModel $model;
    private TurnConfigDayFinderService $finder;

    public function __construct() 
    {
        $this->model = new TurnConfigDayModel();
        $this->finder = new TurnConfigDayFinderService();
    }

    public function delete(
        int $id
    ): void 
    {
        $turnConfigDay = $this->finder->find($id);

        $this->model->delete($turnConfigDay->id());
    }
}

