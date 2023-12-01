<?php

declare(strict_types=1);

namespace Venue\Domain\ValueObject;

enum ContactType: string
{
    public const PHONE = 'phone';
    public const EMAIL = 'email';
    public const WEBSITE = 'website';
    public const FACEBOOK = 'facebook';
    public const INSTAGRAM = 'instagram';
    public const LINKEDIN = 'linkedin';
}
