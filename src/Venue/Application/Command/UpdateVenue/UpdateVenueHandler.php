<?php

declare(strict_types=1);

namespace Venue\Application\Command\UpdateVenue;

use Shared\Domain\Bus\Command\CommandHandlerInterface;
use Venue\Domain\Service\VenueService;

class UpdateVenueHandler implements CommandHandlerInterface
{
    public function __construct(private readonly VenueService $venueService)
    {
    }

    public function __invoke(UpdateVenueCommand $command): void
    {
        $this->venueService->update(
            $command->id,
            $command->updateKeys,
            $command->name,
            $command->type,
            $command->address,
            $command->description,
        );
    }
}
