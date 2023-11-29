<?php

declare(strict_types=1);

namespace Venue\Application\Command\UpdateVenue;

use Ramsey\Uuid\UuidInterface;
use Shared\Domain\Bus\Command\CommandInterface;
use Shared\Domain\ValueObject\Address;
use Venue\Domain\ValueObject\VenueType;

class UpdateVenueCommand implements CommandInterface
{
    public function __construct(
        public readonly UuidInterface $id,
        public readonly array $updateKeys,
        public readonly ?string $name,
        public readonly ?VenueType $type,
        public readonly ?Address $address,
        public readonly ?string $description,
    ) {
    }
}
