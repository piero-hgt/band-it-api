<?php

declare(strict_types=1);

namespace Shared\Domain\ValueObject;

enum AddressType: string
{
    case CUSTOM = 'custom';

    case GOOGLE = 'google';

    public static function values(): array
    {
        return array_map(static fn (self $type) => $type->value, self::cases());
    }
}
