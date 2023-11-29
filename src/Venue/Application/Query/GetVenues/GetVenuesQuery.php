<?php

declare(strict_types=1);

namespace Venue\Application\Query\GetVenues;

use Shared\Domain\Bus\Query\QueryInterface;
use Shared\Domain\ValueObject\Pagination;

class GetVenuesQuery implements QueryInterface
{
    public function __construct(
        public readonly Pagination $pagination
    ) {
    }
}
