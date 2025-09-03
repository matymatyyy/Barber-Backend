<?php 

namespace Src\Service\TurnConfig;

use Src\Entity\TurnConfig\TurnConfig;
use Src\Model\TurnConfig\TurnConfigModel;

final readonly class TurnsConfigSearcherService {
    private TurnConfigModel $turnConfigModel;

    public function __construct() {
        $this->turnConfigModel = new TurnConfigModel();
    }

    /** @return TurnConfig[] */
    public function search(): array
    {
        return $this->turnConfigModel->search();
    }
}