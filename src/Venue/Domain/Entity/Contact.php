<?php

declare(strict_types=1);

namespace Venue\Domain\Entity;

use Carbon\CarbonImmutable;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use Venue\Domain\ValueObject\ContactType;

class Contact
{
    private UuidInterface $id;

    private readonly CarbonImmutable $createdAt;

    private CarbonImmutable $updatedAt;

    private ?Venue $venue = null;

    private ?Person $person = null;

    public function __construct(
        private ContactType $type,
        private string $value
    ) {
        $this->id = Uuid::uuid4();
        $this->createdAt = CarbonImmutable::now();
        $this->updatedAt = CarbonImmutable::now();
    }
}
