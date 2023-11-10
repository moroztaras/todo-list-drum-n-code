<?php

namespace App\Exception\Api;

class UserNotAuthorizedJsonHttpException extends JsonHttpException
{
    public function __construct($message = 'User Not Unauthorized', $data = null)
    {
        parent::__construct(401, $message, $data);
    }
}
