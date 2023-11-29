<?php

declare(strict_types=1);

namespace Shared\Domain\Service;

use Shared\Domain\ValueObject\Pagination;

interface PaginatorServiceInterface
{
    public function fromRequest(int $defaultItemsPerPage): Pagination;
}
