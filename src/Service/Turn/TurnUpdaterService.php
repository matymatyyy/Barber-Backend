<?php 

declare(strict_types = 1);

namespace Src\Service\Turn;

use DateTime;
use Src\Model\Turn\TurnModel;

final readonly class TurnUpdaterService {

    private TurnModel $model;
    private TurnFinderService $finder;

    public function __construct() 
    {
        $this->model = new TurnModel();
        $this->finder = new TurnFinderService();
    }

    public function update(
        int $id,
        ?int $barberId,
        ?int $clientId,
        DateTime $date,
        DateTime $hourBegin,
        DateTime $hourEnd,
        ?bool $state
    ): void 
    {
        $turn = $this->finder->find($id);

        $turn->modify(
        $barberId,
        $clientId,
            $date,
       $hourBegin,
         $hourEnd,
           $state
        );

        $this->model->update($turn);
    }

}

