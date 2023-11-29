<?php

declare(strict_types=1);

namespace Venue\Application\Query\GetVenues;

use Shared\Application\DTO\PaginatedCollectionOutputDTO;
use Shared\Domain\Bus\Query\QueryHandlerInterface;
use Venue\Application\DTO\VenueOutputDTO;
use Venue\Domain\Entity\Venue;
use Venue\Domain\Repository\VenueRepositoryInterface;

class GetVenuesHandler implements QueryHandlerInterface
{
    public function __construct(private readonly VenueRepositoryInterface $repository)
    {
    }

    public function __invoke(GetVenuesQuery $query): PaginatedCollectionOutputDTO
    {
        return new PaginatedCollectionOutputDTO(
            $this->repository->countAll(),
            array_map(
                static fn (Venue $venue) => VenueOutputDTO::fromEntity($venue),
                $this->repository->findAll($query->pagination)
            )
        );
    }
}
