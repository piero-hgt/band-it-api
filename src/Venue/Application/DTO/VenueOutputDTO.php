<?php

declare(strict_types=1);

namespace Venue\Application\DTO;

use Ramsey\Uuid\UuidInterface;
use Shared\Application\DTO\AddressOutputDTO;
use Venue\Domain\Entity\Venue;
use Venue\Domain\ValueObject\VenueType;

class VenueOutputDTO
{
    public function __construct(
        public readonly UuidInterface $id,
        public readonly string $name,
        public readonly VenueType $type,
        public readonly AddressOutputDTO $address,
        public readonly ?string $description
    ) {
    }

    public static function fromEntity(Venue $venue): self
    {
        return new self(
            $venue->getId(),
            $venue->getName(),
            $venue->getType(),
            AddressOutputDTO::fromValueObject($venue->getAddress()),
            $venue->getDescription(),
        );
    }
}
