<?php

declare(strict_types=1);

namespace Venue\Presentation\Http\Rest\Controller;

use Shared\Domain\Bus\Query\QueryBusInterface;
use Shared\Domain\Service\PaginatorServiceInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;
use Venue\Application\Query\GetVenues\GetVenuesQuery;

class GetVenuesController
{
    public function __construct(
        private readonly QueryBusInterface $queryBus,
        private readonly SerializerInterface $serializer,
        private readonly PaginatorServiceInterface $paginatorService
    ) {
    }

    public function __invoke(Request $request): Response
    {
        $venues = $this->queryBus->ask(
            new GetVenuesQuery(
                $this->paginatorService->fromRequest(100)
            )
        );

        return JsonResponse::fromJsonString(
            $this->serializer->serialize(
                $venues,
                'json',
                [
                    AbstractNormalizer::GROUPS => [
                        'read:pagination',
                        'read:venue:list',
                        'read:address',
                    ],
                ]
            )
        );
    }
}
