<?php

declare(strict_types=1);

namespace Venue\Presentation\DTO;

use Shared\Presentation\DTO\AddressInputDTO;
use Symfony\Component\HttpFoundation\Request;

class AddVenueInputDTO
{
    public function __construct(
        public readonly ?string $name,
        public readonly ?string $type,
        public readonly ?AddressInputDTO $address,
        public readonly ?string $description,
        public readonly ?string $season
    ) {
    }

    public static function fromRequest(Request $request): self
    {
        $params = $request->request->all();

        $address = $params['address'] ?? null;

        return new self(
            $params['name'] ?? null,
            $params['type'] ?? null,
            $address ? AddressInputDTO::fromArray($address) : null,
            $params['description'] ?? null,
            $params['season'] ?? null,
        );
    }
}
