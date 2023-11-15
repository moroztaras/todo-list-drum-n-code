<?php

namespace App\Model;

class SingUpModel
{
    /**
     * @var UserModel
     */
    private array $user;

    /**
     * @param UserModel $user
     */
    public function __construct(array $user)
    {
        $this->user = $user;
    }

    /**
     * @return UserModel
     */
    public function getUser(): array
    {
        return $this->user;
    }
}