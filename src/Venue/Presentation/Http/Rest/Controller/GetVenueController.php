<?php

declare(strict_types=1);

namespace Venue\Presentation\Http\Rest\Controller;

use Ramsey\Uuid\Uuid;
use Shared\Domain\Bus\Query\QueryBusInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;
use Venue\Application\Query\GetVenueById\GetVenueByIdQuery;

class GetVenueController
{
    public function __construct(
        private readonly QueryBusInterface $queryBus,
        private readonly SerializerInterface $serializer
    ) {
    }

    public function __invoke(Request $request, string $venueId): Response
    {
        $venue = $this->queryBus->ask(new GetVenueByIdQuery(Uuid::fromString($venueId)));

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
