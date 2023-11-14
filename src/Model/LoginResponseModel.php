<?php

namespace App\Model;

class LoginResponseModel
{
    /**
     * @var LoginModel
     */
    private array $singIn;

    /**
     * @param LoginModel $singIn
     */
    public function __construct(array $singIn)
    {
        $this->singIn = $singIn;
    }

    /**
     * @return LoginModel
     */
    public function getSingIn(): array
    {
        return $this->singIn;
    }
}