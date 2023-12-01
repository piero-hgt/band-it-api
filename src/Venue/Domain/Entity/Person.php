<?php

declare(strict_types=1);

namespace Venue\Domain\Entity;

use Carbon\CarbonImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class Person
{
    private UuidInterface $id;

    private readonly CarbonImmutable $createdAt;

    private CarbonImmutable $updatedAt;

    /**
     * @var Collection<int, Contact>
     */
    private Collection $contacts;

    public function __construct(
        private string $name,
        private ?string $description,
        private Venue $venue
    ) {
        $this->id = Uuid::uuid4();
        $this->createdAt = CarbonImmutable::now();
        $this->updatedAt = CarbonImmutable::now();
        $this->contacts = new ArrayCollection();
    }
}
