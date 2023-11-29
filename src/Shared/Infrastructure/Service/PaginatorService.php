<?php

declare(strict_types=1);

namespace Shared\Infrastructure\Service;

use Shared\Domain\Service\PaginatorServiceInterface;
use Shared\Domain\ValueObject\Pagination;
use Symfony\Component\HttpFoundation\RequestStack;

class PaginatorService implements PaginatorServiceInterface
{
    public function __construct(private readonly RequestStack $requestStack)
    {
    }

    public function fromRequest(int $defaultItemsPerPage = 10): Pagination
    {
        $request = $this->requestStack->getCurrentRequest();

        if (null === $request) {
            return new Pagination(1, $defaultItemsPerPage, 0);
        }

        $limit = $request->query->getInt('itemsPerPage', $defaultItemsPerPage);
        if ($limit > 1000) {
            $limit = 1000;
        }

        $page = $request->query->getInt('page', 1);
        $offset = $limit * ($page - 1);

        return new Pagination($page, $limit, $offset);
    }
}
