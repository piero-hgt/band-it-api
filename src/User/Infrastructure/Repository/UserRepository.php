<?php

declare(strict_types=1);

namespace User\Infrastructure\Repository;

use Doctrine\ORM\EntityManagerInterface;
use User\Domain\Entity\User;
use User\Domain\Repository\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface
{
    public function __construct(private readonly EntityManagerInterface $entityManager)
    {
    }

    public function save(User $user): void
    {
        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }

    public function findOneByEmail(string $email): ?User
    {
        return $this->entityManager
            ->createQueryBuilder()
            ->select('u')
            ->from(User::class, 'u')
            ->where('u.email = :email')
            ->setParameter('email', $email)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function findAll(): array
    {
        return $this->entityManager
            ->createQueryBuilder()
            ->select('u')
            ->from(User::class, 'u')
            ->getQuery()
            ->getResult();
    }

    public function delete(User $user): void
    {
        $this->entityManager->remove($user);
        $this->entityManager->flush();
    }
}
