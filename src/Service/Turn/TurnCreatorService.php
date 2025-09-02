<?php 

declare(strict_types = 1);

namespace Src\Service\Turn;

use DateTime;
use Src\Model\Turn\TurnModel;
use Src\Entity\Turn\Turn;

final readonly class TurnCreatorService {

    private TurnModel $model;

    public function __construct() 
    {
        $this->model = new TurnModel();
    }

    public function create(
        DateTime $date,
        DateTime $hourBegin,
        DateTime $hourEnd,
        ?bool $state,
        ?int $barberId = null,
        ?int $clientId = null): void 
    {
        $Turn = Turn::create(
           $date,
      $hourBegin,
        $hourEnd, 
          $state,
       $barberId,
       $clientId);
       
        $this->model->insert($Turn);
    }

}

