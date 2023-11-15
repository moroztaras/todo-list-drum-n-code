<?php

namespace App\Model;

class ApiKeyModel
{
    private string $apiKey;

    public function getApiKey(): string
    {
        return $this->apiKey;
    }
}