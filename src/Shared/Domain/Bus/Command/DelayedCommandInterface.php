<?php

declare(strict_types=1);

namespace Shared\Domain\Bus\Command;

interface DelayedCommandInterface extends CommandInterface
{
    public const ONE_HOUR = 60 * 60 * 1000;

    /**
     * @return int The delay in milliseconds
     */
    public function getDelay(): int;
}
