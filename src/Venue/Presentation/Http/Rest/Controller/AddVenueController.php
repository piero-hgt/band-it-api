<?php

declare(strict_types=1);

namespace Venue\Presentation\Http\Rest\Controller;

use Shared\Domain\Bus\Command\CommandBusInterface;
use Shared\Domain\Bus\Query\QueryBusInterface;
use Shared\Domain\Validator\ValidatorInterface;
use Shared\Domain\ValueObject\Address;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;
use Venue\Application\Command\AddVenue\AddVenueCommand;
use Venue\Application\Query\GetVenueById\GetVenueByIdQuery;
use Venue\Domain\ValueObject\VenueType;
use Venue\Presentation\DTO\AddVenueInputDTO;

class AddVenueController
{
    public function __construct(
        private readonly CommandBusInterface $commandBus,
        private readonly SerializerInterface $serializer,
        private readonly ValidatorInterface $validator,
        private readonly QueryBusInterface $queryBus
    ) {
    }

    public function __invoke(Request $request): Response
    {
        $addVenue = AddVenueInputDTO::fromRequest($request);

        $this->validator->validate($addVenue);

        $id = $this->commandBus->publish(
            new AddVenueCommand(
                $addVenue->name,
                VenueType::from($addVenue->type),
                Address::fromArray($addVenue->address->toArray()),
                $addVenue->description,
                $addVenue->season,
            )
        );

        $venue = $this->queryBus->ask(new GetVenueByIdQuery($id));

        return JsonResponse::fromJsonString(
            $this->serializer->serialize(
                $venue,
                'json',
                [
                    AbstractNormalizer::GROUPS => [
                        'read:venue:item',
                        'read:address',
                    ],
                ]
            )
        );
    }
}
