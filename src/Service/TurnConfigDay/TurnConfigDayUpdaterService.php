<?php 

declare(strict_types = 1);

namespace Src\Service\TurnConfigDay;

use DateTime;
use Src\Model\TurnConfigDay\TurnConfigDayModel;

final readonly class TurnConfigDayUpdaterService {

    private TurnConfigDayModel $model;
    private TurnConfigDayFinderService $finder;

    public function __construct() 
    {
        $this->model = new TurnConfigDayModel();
        $this->finder = new TurnConfigDayFinderService();
    }

    public function update(
        int $id,
        ?int $turnConfigId,
        string $day,
        DateTime $hourBegin,
        DateTime $hourEnd,
        DateTime $turnTime
    ): void 
    
    {

        $turnConfigDay= $this->finder->find($id);

        $turnConfigDay->modify(
         $turnConfigId,
        $day,
       $hourBegin,
         $hourEnd,
            $turnTime
        );

        $this->model->update($turnConfigDay);
    }

}

