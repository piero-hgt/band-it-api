<?php

declare(strict_types=1);

namespace Venue\Application\Command\AddVenue;

use Shared\Domain\Bus\Command\CommandInterface;
use Shared\Domain\ValueObject\Address;
use Venue\Domain\ValueObject\VenueType;

class AddVenueCommand implements CommandInterface
{
    public function __construct(
        public readonly string $name,
        public readonly VenueType $type,
        public readonly Address $address,
        public readonly ?string $description,
        public readonly ?string $season,
    ) {
    }
}
