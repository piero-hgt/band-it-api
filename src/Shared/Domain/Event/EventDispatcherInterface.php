<?php

declare(strict_types=1);

namespace Shared\Domain\Event;

interface EventDispatcherInterface
{
    public function dispatch(object $event): object;
}
