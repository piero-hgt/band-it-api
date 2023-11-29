<?php

declare(strict_types=1);

namespace User\Domain\Service;

use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use User\Domain\Entity\User;
use User\Domain\Repository\UserRepositoryInterface;

class UserService
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository,
        private readonly UserPasswordHasherInterface $passwordHasher
    ) {
    }

    public function create(
        string $username,
        string $email,
        string $plainPassword,
    ): User {
        $user = new User($username, $email);
        $password = $this->passwordHasher->hashPassword($user, $plainPassword);
        $user->setPassword($password);

        $this->userRepository->save($user);

        return $user;
    }

    public function enable(User $user): void
    {
        $user->enable();
        $this->userRepository->save($user);
    }
}
