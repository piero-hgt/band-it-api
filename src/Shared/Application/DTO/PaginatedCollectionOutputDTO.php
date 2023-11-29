<?php

declare(strict_types=1);

namespace Shared\Application\DTO;

class PaginatedCollectionOutputDTO
{
    public function __construct(private readonly int $count, protected array $data)
    {
    }

    public function getCount(): int
    {
        return $this->count;
    }

    public function getData(): array
    {
        return $this->data;
    }
}
