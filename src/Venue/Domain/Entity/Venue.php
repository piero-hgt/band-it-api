<?php

declare(strict_types=1);

namespace Venue\Domain\Entity;

use Carbon\CarbonImmutable;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use Shared\Domain\ValueObject\Address;
use Shared\Domain\ValueObject\File;
use Venue\Domain\ValueObject\VenueType;

class Venue
{
    private readonly UuidInterface $id;
    private readonly CarbonImmutable $createdAt;
    private CarbonImmutable $updatedAt;

    public function __construct(
        private string $name,
        private VenueType $type,
        private Address $address,
        private ?string $description,
        private ?File $avatar
    ) {
        $this->id = Uuid::uuid4();
        $this->createdAt = CarbonImmutable::now();
        $this->updatedAt = CarbonImmutable::now();
    }

    public function getId(): UuidInterface
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getType(): VenueType
    {
        return $this->type;
    }

    public function getAddress(): Address
    {
        return $this->address;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function setType(VenueType $type): void
    {
        $this->type = $type;
    }

    public function setAddress(Address $address): void
    {
        $this->address = $address;
    }

    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }
}
