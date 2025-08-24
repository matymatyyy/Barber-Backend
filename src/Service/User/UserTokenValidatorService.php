<?php 

declare(strict_types = 1);

namespace Src\Service\User;

use Src\Model\User\UserModel;
use Src\Entity\User\User;
use Src\Entity\User\Exception\UserNotAuthorizedException;

final readonly class UserTokenValidatorService {

    private UserModel $model;

    public function __construct() 
    {
        $this->model = new UserModel();
    }

    public function validate(string $token): User 
    {
        $user = $this->model->findByToken($token);

        if ($user === null) {
            throw new UserNotAuthorizedException();
        }

        return $user;
    }

}

