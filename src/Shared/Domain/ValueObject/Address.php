<?php

declare(strict_types=1);

namespace Shared\Domain\ValueObject;

class Address
{
    public function __construct(
        public readonly AddressType $addressType,
        public readonly ?string $line1 = null,
        public readonly ?string $line2 = null,
        public readonly ?string $zipcode = null,
        public readonly ?string $city = null,
        public readonly ?string $state = null,
        public readonly ?string $country = null,
    ) {
    }

    public static function fromArray(array $address): self
    {
        $addressType = $address['addressType'] ?? null;

        return new self(
            $addressType ? AddressType::from($addressType) : AddressType::CUSTOM,
            $address['line1'] ?? null,
            $address['line2'] ?? null,
            $address['zipcode'] ?? null,
            $address['city'] ?? null,
            $address['state'] ?? null,
            $address['country'] ?? null,
        );
    }
}
