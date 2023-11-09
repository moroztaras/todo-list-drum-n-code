<?php

namespace App\Manager;

use App\Entity\User;
use App\Exception\UserAlreadyExistsException;
use App\Repository\UserRepository;
use App\Validator\Helper\ApiObjectValidator;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Serializer\Normalizer\UnwrappingDenormalizer;
use Ramsey\Uuid\Nonstandard\Uuid;

class AuthManager
{
    public function __construct(
        private ManagerRegistry $doctrine,
        private ApiObjectValidator $apiObjectValidator,
        private UserRepository $userRepository,
        private UserPasswordHasherInterface $passwordEncoder,
    ) {
    }

    public function createNewUser(string $content):User
    {
        /** @var User $user */
        $user = $this->apiObjectValidator->deserializeAndValidate($content, User::class, [
            UnwrappingDenormalizer::UNWRAP_PATH => '[user]',
            'sing-up' => true,
        ]);

        if ($this->userRepository->existsByEmail($user->getEmail())) {
            throw new UserAlreadyExistsException();
        }

        $this->save($user, $user->getPlainPassword());

        return $user;
    }

    private function save(User $user, string $password = null): void
    {
        if ($password) {
            $user
                ->setPassword($this->passwordEncoder->hashPassword($user, $password))
                ->setApiKey(Uuid::uuid4()->toString())
            ;
        }

        $this->doctrine->getManager()->persist($user);
        $this->doctrine->getManager()->flush();
    }
}