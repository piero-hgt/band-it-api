<?php

declare(strict_types=1);

namespace Venue\Domain\Entity;

use Carbon\CarbonImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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

    /**
     * @var Collection<int, Contact>
     */
    private Collection $contacts;

    /**
     * @var Collection<int, Person>
     */
    private Collection $persons;

    public function __construct(
        private string $name,
        private VenueType $type,
        private Address $address,
        private ?string $description = null,
        private ?File $avatar = null,
        private ?string $season = null,
    ) {
        $this->id = Uuid::uuid4();
        $this->createdAt = CarbonImmutable::now();
        $this->updatedAt = CarbonImmutable::now();
        $this->contacts = new ArrayCollection();
        $this->persons = new ArrayCollection();
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

    public function update(array $updatedAt): void
    {
        foreach ($updatedAt as $key => $value) {
            $this->$key = $value;
        }
        $this->updatedAt = CarbonImmutable::now();
    }
}
