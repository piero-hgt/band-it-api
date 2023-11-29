<?php

declare(strict_types=1);

namespace Shared\Infrastructure\Bus\Event;

use Shared\Domain\Bus\Event\EventBusInterface;
use Shared\Domain\Bus\Event\EventInterface;
use Symfony\Component\Messenger\MessageBusInterface;

class SymfonyEventBus implements EventBusInterface
{
    public function __construct(private readonly MessageBusInterface $eventBus)
    {
    }

    public function dispatch(EventInterface $event): void
    {
        $this->eventBus->dispatch($event);
    }
}
