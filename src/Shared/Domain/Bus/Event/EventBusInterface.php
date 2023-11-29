<?php

declare(strict_types=1);

namespace Shared\Domain\Bus\Event;

interface EventBusInterface
{
    public function dispatch(EventInterface $event): void;
}
