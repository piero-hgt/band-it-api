<?php

declare(strict_types=1);

namespace Venue\Presentation\DTO;

use Shared\Presentation\DTO\AddressInputDTO;
use Symfony\Component\HttpFoundation\Request;

class AddVenueInputDTO
{
    public function __construct(
        public readonly string $name,
        public readonly string $type,
        public readonly AddressInputDTO $address,
        public readonly ?string $description
    ) {
    }

    public static function fromRequest(Request $request): self
    {
        $params = $request->request->all();

        return new self(
            $params['name'],
            $params['type'],
            AddressInputDTO::fromArray($params['address']),
            $params['description'] ?? null,
        );
    }
}
