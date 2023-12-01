<?php

declare(strict_types=1);

namespace Venue\Application\Command\AddVenue;

use Ramsey\Uuid\UuidInterface;
use Shared\Domain\Bus\Command\CommandHandlerInterface;
use Venue\Domain\Service\VenueService;

class AddVenueHandler implements CommandHandlerInterface
{
    public function __construct(
        private readonly VenueService $venueService,
    ) {
    }

    public function __invoke(AddVenueCommand $command): UuidInterface
    {
        $venue = $this->venueService->create(
            $command->name,
            $command->type,
            $command->address,
            $command->description,
            $command->season,
        );

        return $venue->getId();
    }
}
