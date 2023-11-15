<?php

namespace App\Model;

class UserApiKeyResponseModel
{
    /**
     * @var ApiKeyModel
     */
    private array $user;

    /**
     * @param ApiKeyModel $apiKey
     */
    public function __construct(array $apiKey)
    {
        $this->user = $apiKey;
    }

    /**
     * @return UserApiKeyResponseModel
     */
    public function getUser(): array
    {
        return $this->user;
    }
}