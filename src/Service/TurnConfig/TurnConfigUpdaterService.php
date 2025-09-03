<?php 

declare(strict_types = 1);

namespace Src\Service\TurnConfig;


use Src\Model\TurnConfig\TurnConfigModel;

final readonly class TurnConfigUpdaterService {

    private TurnConfigModel $model;
    private TurnConfigFinderService $finder;

    public function __construct() 
    {
        $this->model = new TurnConfigModel();
        $this->finder = new TurnConfigFinderService();
    }

    public function update(
        int $id,
        ?int $barberId,
    ): void 
    {
        $turnConfig = $this->finder->find($id);

        $turnConfig->modify(
        $barberId
        );

        $this->model->update($turnConfig);
    }

}

