<?php

namespace App\Model;

class SingUpResponseModel
{
    /**
     * @var UserResponseModel
     */
    private array $user;

    /**
     * @param UserResponseModel $user
     */
    public function __construct(array $user)
    {
        $this->user = $user;
    }

    /**
     * @return UserResponseModel
     */
    public function getUser(): array
    {
        return $this->user;
    }
}