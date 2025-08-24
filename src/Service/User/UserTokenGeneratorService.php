<?php 

declare(strict_types = 1);

namespace Src\Service\User;

use Src\Model\User\UserModel;
use Src\Entity\User\User;

final readonly class UserTokenGeneratorService {

    private UserModel $model;

    public function __construct() 
    {
        $this->model = new UserModel();
    }

    public function generate(User $user): User 
    {
        $user->generateToken();
        $this->model->update($user);
        return $user;
    }

}

