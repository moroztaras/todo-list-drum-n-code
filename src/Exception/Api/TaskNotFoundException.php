<?php

namespace App\Exception\Api;

class TaskNotFoundException extends JsonHttpException
{
    public function __construct($message = 'Tasks Not Found', $data = null)
    {
        parent::__construct(404, $message, $data);
    }
}
