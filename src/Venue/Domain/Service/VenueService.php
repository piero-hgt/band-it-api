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
    ): void {
        $venue = new Venue(
            $name,
            $type,
            $address,
            $description,
            null
        );

        $this->venueRepository->save($venue);
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

        foreach ($updateKeys as $key) {
            switch ($key) {
                case 'name':
                    if (null === $name) {
                        throw FieldCannotBeNullException::fromEntityAndField(Venue::class, $key);
                    }
                    $venue->setName($name);
                    break;
                case 'type':
                    if (null === $type) {
                        throw FieldCannotBeNullException::fromEntityAndField(Venue::class, $key);
                    }
                    $venue->setType($type);
                    break;
                case 'address':
                    if (null === $address) {
                        throw FieldCannotBeNullException::fromEntityAndField(Venue::class, $key);
                    }

                    $venue->setAddress($address);
                    break;
                case 'description':
                    $venue->setDescription($description);
                    break;
            }
        }

        $this->venueRepository->save($venue);
    }
}
