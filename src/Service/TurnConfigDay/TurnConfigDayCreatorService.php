<?php 

declare(strict_types = 1);

namespace Src\Service\TurnConfigDay;

use DateTime;
use Src\Model\TurnConfigDay\TurnConfigDayModel;
use Src\Entity\TurnConfigDay\TurnConfigDay;

final readonly class TurnConfigDayCreatorService {

    private TurnConfigDayModel $model;

    public function __construct() 
    {
        $this->model = new TurnConfigDayModel();
    }

    public function create(
        ?int $turnConfigId,
        string $day,
        DateTime $turnTime,
        DateTime $hourBegin,
        DateTime $hourEnd,): void 
    {
        $turnConfigDay = TurnConfigDay::create(
          $turnConfigId,
        $day,
        $turnTime,
        $hourBegin,
        $hourEnd,
    );
       
        $this->model->insert($turnConfigDay);
    }

}

