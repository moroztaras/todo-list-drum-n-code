<?php

namespace App\Normalizer;

use App\Entity\User;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class UserNormalizer implements NormalizerInterface
{
    /**
     * @@param User $object object to normalize
     * @param null $format
     *
     * @return array|bool|float|int|string
     */
    public function normalize($object, $format = null, array $context = []): array
    {
        if (isset($context['signIn'])) {
            return [
                'apiKey' => $object->getApiKey(),
            ];
        }

        return [
            'uuid' => $object->getUuid(),
            'firstName' => $object->getFirstName(),
            'lastName' => $object->getLastName(),
            'email' => $object->getEmail(),
            'gender' => $object->getGender(),
            'birthday' => $object->getBirthday()->format('d-m-Y'),
            'country' => $object->getCountry(),
            'blocked' => $object->isStatus(),
            'createdAt' => $object->getCreatedAt()->format('d-m-Y'),
        ];
    }

    public function supportsNormalization($user, $format = null)
    {
        return $user instanceof User;
    }
}
