<?php

declare(strict_types=1);

namespace Shared\Application\DTO;

use Shared\Domain\ValueObject\Address;

class AddressOutputDTO
{
    public function __construct(
        public readonly string $line1,
        public readonly ?string $line2,
        public readonly string $zipcode,
        public readonly string $city,
        public readonly ?string $state,
        public readonly string $country,
    ) {
    }

    public static function fromValueObject(Address $address): self
    {
        return new self(
            $address->line1 ?? '',
            $address->line2,
            $address->zipcode ?? '',
            $address->city ?? '',
            $address->state,
            $address->country ?? '',
        );
    }
}
