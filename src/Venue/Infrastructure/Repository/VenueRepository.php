<?php

declare(strict_types=1);

namespace Venue\Infrastructure\Repository;

use Doctrine\ORM\EntityManagerInterface;
use Ramsey\Uuid\UuidInterface;
use Shared\Domain\ValueObject\Pagination;
use Venue\Domain\Entity\Venue;
use Venue\Domain\Exception\VenueNotFoundException;
use Venue\Domain\Repository\VenueRepositoryInterface;

class VenueRepository implements VenueRepositoryInterface
{
    public function __construct(private readonly EntityManagerInterface $entityManager)
    {
    }

    public function findOneById(UuidInterface $id): Venue
    {
        $venue = $this->entityManager
            ->createQueryBuilder()
            ->select('v')
            ->from(Venue::class, 'v')
            ->where('v.id = :id')
            ->setParameter('id', $id->toString())
            ->getQuery()
            ->getOneOrNullResult();

        if (null === $venue) {
            throw VenueNotFoundException::fromId($id);
        }

        return $venue;
    }

    public function save(Venue $venue): void
    {
        $this->entityManager->persist($venue);
        $this->entityManager->flush();
    }

    public function delete(Venue $venue): void
    {
        $this->entityManager->remove($venue);
        $this->entityManager->flush();
    }

    public function findAll(Pagination $pagination): array
    {
        return $this->entityManager
            ->createQueryBuilder()
            ->select('v')
            ->from(Venue::class, 'v')
            ->setFirstResult($pagination->offset)
            ->setMaxResults($pagination->limit)
            ->getQuery()
            ->getResult();
    }

    public function countAll(): int
    {
        return (int) $this->entityManager
            ->createQueryBuilder()
            ->select('COUNT(v)')
            ->from(Venue::class, 'v')
            ->getQuery()
            ->getSingleScalarResult();
    }
}
