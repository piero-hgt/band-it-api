<?php

declare(strict_types=1);

namespace Venue\Domain\Exception;

use Exception as BaseException;
use Ramsey\Uuid\UuidInterface;

class VenueNotFoundException extends BaseException implements Exception
{
    public static function fromId(UuidInterface $id): self
    {
        return new self(sprintf('Venue not found for id "%s"', $id->toString()));
    }
}
