<?php

declare(strict_types=1);

namespace User\Domain\Repository;

use User\Domain\Entity\User;

interface UserRepositoryInterface
{
    public function save(User $user): void;

    public function findOneByEmail(string $email): ?User;

    public function findAll(): array;

    public function delete(User $user): void;
}
