<?php

declare(strict_types=1);

namespace Venue\Presentation\DTO;

use Ramsey\Uuid\UuidInterface;
use Shared\Presentation\DTO\AddressInputDTO;
use Symfony\Component\HttpFoundation\Request;

class UpdateVenueInputDTO
{
    public function __construct(
        public readonly array $updateKeys,
        public readonly ?string $name,
        public readonly ?string $type,
        public readonly ?AddressInputDTO $address,
        public readonly ?string $description
    ) {
    }

    public static function fromRequest(Request $request, UuidInterface $id): self
    {
        $params = $request->request->all();
        $addressData = $params['address'] ?? null;

        return new self(
            $request->request->keys(),
            $params['name'] ?? null,
            $params['type'] ?? null,
            $addressData ? AddressInputDTO::fromArray($addressData) : null,
            $params['description'] ?? null,
        );
    }
}
