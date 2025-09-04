<?php 

namespace Src\Service\TurnConfigDay;

use Src\Entity\TurnConfigDay\TurnConfigDay;
use Src\Model\TurnConfigDay\TurnConfigDayModel;

final readonly class TurnsConfigDaySearcherService {
    private TurnConfigDayModel $turnModel;

    public function __construct() {
        $this->turnModel = new TurnConfigDayModel();
    }

    /** @return TurnConfigDay[] */
    public function search(): array
    {
        return $this->turnModel->search();
    }
}