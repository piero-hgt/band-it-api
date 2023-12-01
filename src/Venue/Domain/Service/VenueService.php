<?php

declare(strict_types=1);

namespace Venue\Domain\Service;

use Ramsey\Uuid\UuidInterface;
use Shared\Domain\Exception\FieldCannotBeNullException;
use Shared\Domain\ValueObject\Address;
use Venue\Domain\Entity\Venue;
use Venue\Domain\Repository\VenueRepositoryInterface;
use Venue\Domain\ValueObject\VenueType;

class VenueService
{
    public function __construct(private readonly VenueRepositoryInterface $venueRepository)
    {
    }

    public function create(
        string $name,
        VenueType $type,
        Address $address,
        ?string $description,
        ?string $season,
    ): Venue {
        $venue = new Venue(
            $name,
            $type,
            $address,
            $description,
        );

        $this->venueRepository->save($venue);

        return $venue;
    }

    public function update(
        UuidInterface $id,
        array $updateKeys,
        ?string $name,
        ?VenueType $type,
        ?Address $address,
        ?string $description,
    ): void {
        $venue = $this->venueRepository->findOneById($id);

        $updates = [];
        foreach ($updateKeys as $key) {
            switch ($key) {
                case 'name':
                    if (null === $name) {
                        throw FieldCannotBeNullException::fromEntityAndField(Venue::class, $key);
                    }
                    $updates[$key] = $name;
                    break;
                case 'type':
                    if (null === $type) {
                        throw FieldCannotBeNullException::fromEntityAndField(Venue::class, $key);
                    }
                    $updates[$key] = $type;
                    break;
                case 'address':
                    if (null === $address) {
                        throw FieldCannotBeNullException::fromEntityAndField(Venue::class, $key);
                    }

                    $updates[$key] = $address;
                    break;
                case 'description':
                    $updates[$key] = $description;
                    break;
            }
        }

        $venue->update($updates);

        $this->venueRepository->save($venue);
    }
}
