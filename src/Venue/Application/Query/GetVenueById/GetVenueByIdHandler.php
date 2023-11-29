<?php

declare(strict_types=1);

namespace Venue\Application\Query\GetVenueById;

use Shared\Domain\Bus\Query\QueryHandlerInterface;
use Venue\Application\DTO\VenueOutputDTO;
use Venue\Domain\Repository\VenueRepositoryInterface;

class GetVenueByIdHandler implements QueryHandlerInterface
{
    public function __construct(private readonly VenueRepositoryInterface $repository)
    {
    }

    public function __invoke(GetVenueByIdQuery $query): VenueOutputDTO
    {
        return VenueOutputDTO::fromEntity($this->repository->findOneById($query->venueId));
    }
}
