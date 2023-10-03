<?php

namespace App\Exception\Api;

class ForbiddenJsonHttpException extends JsonHttpException
{
    public function __construct($message = 'Forbidden', $data = null)
    {
        parent::__construct(403, $message, $data);
    }
}
