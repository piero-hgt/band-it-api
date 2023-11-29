<?php

declare(strict_types=1);

namespace Shared\Presentation\DTO;

class AddressInputDTO
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

    public static function fromArray(array $array): self
    {
        return new self(
            $array['line1'],
            $array['line2'] ?? null,
            $array['zipcode'],
            $array['city'],
            $array['state'] ?? null,
            $array['country'],
        );
    }

    public function toArray(): array
    {
        return [
            'line1' => $this->line1,
            'line2' => $this->line2,
            'zipcode' => $this->zipcode,
            'city' => $this->city,
            'state' => $this->state,
            'country' => $this->country,
        ];
    }
}
