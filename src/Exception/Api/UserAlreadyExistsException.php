<?php

namespace App\Exception\Api;

use RuntimeException;

class UserAlreadyExistsException extends RuntimeException
{
    public function __construct()
    {
        parent::__construct('User already exists');
    }
}