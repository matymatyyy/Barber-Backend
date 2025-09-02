<?php 

declare(strict_types = 1);

namespace Src\Service\TurnConfig;

use Src\Model\TurnConfig\TurnConfigModel;

final readonly class TurnConfigDeleterService {

    private TurnConfigModel $model;
    private TurnConfigFinderService $finder;

    public function __construct() 
    {
        $this->model = new TurnConfigModel();
        $this->finder = new TurnConfigFinderService();
    }

    public function delete(
        int $id
    ): void 
    {
        $turnConfig = $this->finder->find($id);

        $this->model->delete($turnConfig->id());
    }
}

