<?php

declare(strict_types=1);

namespace Shared\Domain\ValueObject;

class Pagination
{
    public function __construct(
        public readonly int $page,
        public readonly int $limit,
        public readonly int $offset,
    ) {
    }
}
