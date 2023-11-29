<?php

declare(strict_types=1);

namespace Shared\Infrastructure\Event;

use Shared\Domain\Bus\Event\EventBusInterface;
use Shared\Domain\Bus\Event\EventInterface;
use Shared\Domain\Event\EventDispatcherInterface;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface as SymfonyEventDispatcher;

final class EventDispatcher implements EventDispatcherInterface
{
    public function __construct(
        private readonly SymfonyEventDispatcher $eventDispatcher,
        private readonly EventBusInterface $eventBus
    ) {
    }

    public function dispatch(object $event): object
    {
        $result = $this->eventDispatcher->dispatch($event);

        if ($event instanceof EventInterface) {
            $this->eventBus->dispatch($event);
        }

        return $result;
    }
}
