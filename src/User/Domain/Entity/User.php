<?php

declare(strict_types=1);

namespace User\Domain\Entity;

use Carbon\CarbonImmutable;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    private readonly UuidInterface $id;
    private ?string $password = null;
    private array $role;
    private readonly CarbonImmutable $createdAt;
    private CarbonImmutable $updatedAt;

    private bool $enabled = false;

    public function __construct(
        private string $username,
        private string $email,
    ) {
        $this->id = Uuid::uuid4();
        $this->createdAt = CarbonImmutable::now();
        $this->updatedAt = CarbonImmutable::now();
        $this->role = ['ROLE_USER'];
    }

    public function getId(): UuidInterface
    {
        return $this->id;
    }

    public function enable(): void
    {
        $this->enabled = true;
    }

    public function getRoles(): array
    {
        return $this->role;
    }

    public function getUserIdentifier(): string
    {
        return $this->email;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function eraseCredentials(): void
    {
        $this->password = '';
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }
}
