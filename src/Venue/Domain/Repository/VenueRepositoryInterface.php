<?php

declare(strict_types=1);

namespace Venue\Domain\Repository;

use Ramsey\Uuid\UuidInterface;
use Shared\Domain\ValueObject\Pagination;
use Venue\Domain\Entity\Venue;
use Venue\Domain\Exception\VenueNotFoundException;

interface VenueRepositoryInterface
{
    /**
     * @throws VenueNotFoundException
     */
    public function findOneById(UuidInterface $id): Venue;

    public function save(Venue $venue): void;

    public function delete(Venue $venue): void;

    public function countAll(): int;

    public function findAll(Pagination $pagination): array;
}
