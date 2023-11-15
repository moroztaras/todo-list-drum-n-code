<?php

namespace App\Exception\Api;

class UserAlreadyExistsException extends \RuntimeException
{
    public function __construct()
    {
        parent::__construct('User already exists');
    }
}
