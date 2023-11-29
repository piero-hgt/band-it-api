<?php

declare(strict_types=1);

namespace Venue\Application\Query\GetVenueById;

use Ramsey\Uuid\UuidInterface;
use Shared\Domain\Bus\Query\QueryInterface;

class GetVenueByIdQuery implements QueryInterface
{
    public function __construct(public readonly UuidInterface $venueId)
    {
    }
}
