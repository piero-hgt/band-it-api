<?php

declare(strict_types=1);

namespace Venue\Domain\ValueObject;

enum VenueType: string
{
    case BAR = 'bar';
    case FESTIVAL = 'festival';
    case CONCERT_HALL = 'concert_hall';

    public static function values(): array
    {
        return array_map(static fn (self $type) => $type->value, self::cases());
    }
}
