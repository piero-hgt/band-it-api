<?php

declare(strict_types=1);

namespace Venue\Presentation\Http\Rest\Controller;

use Ramsey\Uuid\Uuid;
use Shared\Domain\Bus\Command\CommandBusInterface;
use Shared\Domain\Validator\ValidatorInterface;
use Shared\Domain\ValueObject\Address;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\Transport\Serialization\SerializerInterface;
use Venue\Application\Command\UpdateVenue\UpdateVenueCommand;
use Venue\Domain\ValueObject\VenueType;
use Venue\Presentation\DTO\UpdateVenueInputDTO;

class UpdateVenueController
{
    public function __construct(
        private readonly CommandBusInterface $commandBus,
        private readonly SerializerInterface $serializer,
        private readonly ValidatorInterface $validator
    ) {
    }

    public function __invoke(Request $request, string $venueId): Response
    {
        $venue = UpdateVenueInputDTO::fromRequest($request, Uuid::fromString($venueId));
        $this->validator->validate($venue);

        $this->commandBus->publish(
            new UpdateVenueCommand(
                Uuid::fromString($venueId),
                $venue->updateKeys,
                $venue->name,
                $venue->type ? VenueType::from($venue->type) : null,
                $venue->address ? Address::fromArray($venue->address->toArray()) : null,
                $venue->description
            )
        );

        return new Response();
    }
}
