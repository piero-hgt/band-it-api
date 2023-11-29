<?php

declare(strict_types=1);

namespace Venue\Presentation\Http\Rest\Controller;

use Shared\Domain\Bus\Command\CommandBusInterface;
use Shared\Domain\Validator\ValidatorInterface;
use Shared\Domain\ValueObject\Address;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;
use Venue\Application\Command\AddVenue\AddVenueCommand;
use Venue\Domain\ValueObject\VenueType;
use Venue\Presentation\DTO\AddVenueInputDTO;

class AddVenueController
{
    public function __construct(
        private readonly CommandBusInterface $commandBus,
        private readonly SerializerInterface $serializer,
        private readonly ValidatorInterface $validator
    ) {
    }

    public function __invoke(Request $request): Response
    {
        $addVenue = AddVenueInputDTO::fromRequest($request);

        $this->validator->validate($addVenue);

        $this->commandBus->publish(
            new AddVenueCommand(
                $addVenue->name,
                VenueType::from($addVenue->type),
                Address::fromArray($addVenue->address->toArray()),
                $addVenue->description,
            )
        );

        return new Response();
    }
}
